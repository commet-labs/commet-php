<?php

declare(strict_types=1);

namespace Commet\Tests;

use Commet\HttpClient;
use Commet\Models\BulkSeatUpdate;
use Commet\Models\SeatBalance;
use Commet\Models\SeatEvent;
use Commet\Resources\SeatsResource;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class SeatsTest extends TestCase
{
    /** @var list<array<string, mixed>> */
    private array $history = [];

    /**
     * @param list<Response> $responses
     */
    private function seatsWithResponses(array $responses): SeatsResource
    {
        $stack = HandlerStack::create(new MockHandler($responses));
        $this->history = [];
        $stack->push(Middleware::history($this->history));
        $http = new HttpClient('ck_test_123', handler: $stack);
        return new SeatsResource($http);
    }

    /** @return array<string, mixed> */
    private function sentBody(int $index = 0): array
    {
        return json_decode((string) $this->history[$index]['request']->getBody(), true);
    }

    private function response(mixed $data): Response
    {
        return new Response(200, ['Content-Type' => 'application/json'], json_encode([
            'success' => true,
            'data' => $data,
        ], JSON_THROW_ON_ERROR));
    }

    public function testAddSendsCustomerIdAndFeatureCodeAsCamelCase(): void
    {
        $seats = $this->seatsWithResponses([
            $this->response([
                'id' => 'se_1',
                'customer_id' => 'cus_1',
                'feature_code' => 'editor',
                'previous_balance' => 5,
                'new_balance' => 8,
                'ts' => '2026-06-08T00:00:00Z',
                'created_at' => '2026-06-08T00:00:00Z',
                'object' => 'seat_event',
                'livemode' => false,
            ]),
        ]);

        $result = $seats->add(customerId: 'cus_1', featureCode: 'editor', count: 3);

        $body = $this->sentBody();
        $this->assertSame('cus_1', $body['customerId']);
        $this->assertSame('editor', $body['featureCode']);
        $this->assertSame(3, $body['count']);
        $this->assertArrayNotHasKey('customer_id', $body);
        $this->assertArrayNotHasKey('feature_code', $body);

        $this->assertInstanceOf(SeatEvent::class, $result->data);
        $this->assertSame(5, $result->data->previousBalance);
        $this->assertSame(8, $result->data->newBalance);
    }

    public function testSetAllSendsSeatsMapAndHydratesBulkUpdateList(): void
    {
        $seats = $this->seatsWithResponses([
            $this->response([
                [
                    'id' => 'se_a',
                    'feature_code' => 'editor',
                    'previous_balance' => 2,
                    'new_balance' => 5,
                    'ts' => '2026-06-08T00:00:00Z',
                    'created_at' => '2026-06-08T00:00:00Z',
                    'object' => 'bulk_seat_update',
                    'livemode' => false,
                ],
                [
                    'id' => 'se_b',
                    'feature_code' => 'admin',
                    'previous_balance' => 1,
                    'new_balance' => 1,
                    'ts' => '2026-06-08T00:00:00Z',
                    'created_at' => '2026-06-08T00:00:00Z',
                    'object' => 'bulk_seat_update',
                    'livemode' => false,
                ],
            ]),
        ]);

        $result = $seats->setAll(customerId: 'cus_1', seats: ['editor' => 5, 'admin' => 1]);

        $body = $this->sentBody();
        $this->assertSame('cus_1', $body['customerId']);
        // The seats map is a value payload; its string keys are feature codes, not field names.
        $this->assertSame(5, $body['seats']['editor']);
        $this->assertSame(1, $body['seats']['admin']);

        $this->assertIsArray($result->data);
        $this->assertCount(2, $result->data);
        $this->assertInstanceOf(BulkSeatUpdate::class, $result->data[0]);
        $this->assertSame('editor', $result->data[0]->featureCode);
        $this->assertSame(5, $result->data[0]->newBalance);
    }

    public function testGetBalanceHydratesCurrentAndAsOf(): void
    {
        $seats = $this->seatsWithResponses([
            $this->response([
                'current' => 10,
                'as_of' => '2026-06-08T00:00:00Z',
                'object' => 'seat_balance',
                'livemode' => false,
            ]),
        ]);

        $result = $seats->getBalance(customerId: 'cus_1', featureCode: 'editor');

        $query = $this->history[0]['request']->getUri()->getQuery();
        $this->assertStringContainsString('customerId=cus_1', $query);
        $this->assertStringContainsString('featureCode=editor', $query);

        $this->assertInstanceOf(SeatBalance::class, $result->data);
        $this->assertSame(10, $result->data->current);
        $this->assertSame('2026-06-08T00:00:00Z', $result->data->asOf);
    }
}
