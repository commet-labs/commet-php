<?php

declare(strict_types=1);

namespace Commet\Tests;

use Commet\HttpClient;
use Commet\Models\CreditPack;
use Commet\Resources\CreditPacksResource;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class CreditPacksTest extends TestCase
{
    /** @var list<array<string, mixed>> */
    private array $history = [];

    /**
     * @param list<Response> $responses
     */
    private function creditPacksWithResponses(array $responses): CreditPacksResource
    {
        $stack = HandlerStack::create(new MockHandler($responses));
        $this->history = [];
        $stack->push(Middleware::history($this->history));
        $http = new HttpClient('ck_test_123', handler: $stack);
        return new CreditPacksResource($http);
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

    public function testCreateSendsIsActiveAsCamelCaseAndHydratesPack(): void
    {
        $creditPacks = $this->creditPacksWithResponses([
            $this->response([
                'id' => 'cp_1',
                'name' => '100 Credits',
                'credits' => 100,
                'price' => 999,
                'object' => 'credit_pack',
                'livemode' => false,
                'currency' => 'USD',
                'is_active' => true,
                'created_at' => '2026-06-08T00:00:00Z',
            ]),
        ]);

        $result = $creditPacks->create(
            name: '100 Credits',
            credits: 100,
            price: 999,
            isActive: true,
        );

        $body = $this->sentBody();
        $this->assertSame(100, $body['credits']);
        $this->assertSame(999, $body['price']);
        $this->assertTrue($body['isActive']);
        $this->assertArrayNotHasKey('is_active', $body);
        // description was null -> omitted.
        $this->assertArrayNotHasKey('description', $body);

        $this->assertInstanceOf(CreditPack::class, $result->data);
        $this->assertSame('cp_1', $result->data->id);
        $this->assertTrue($result->data->isActive);
        $this->assertSame('2026-06-08T00:00:00Z', $result->data->createdAt);
        $this->assertNull($result->data->description);
    }

    public function testListHydratesPackCollection(): void
    {
        $creditPacks = $this->creditPacksWithResponses([
            $this->response([
                [
                    'id' => 'cp_1',
                    'name' => 'Small',
                    'credits' => 100,
                    'price' => 999,
                    'object' => 'credit_pack',
                    'livemode' => false,
                ],
                [
                    'id' => 'cp_2',
                    'name' => 'Large',
                    'credits' => 1000,
                    'price' => 8999,
                    'object' => 'credit_pack',
                    'livemode' => false,
                    'description' => 'Bulk pack',
                ],
            ]),
        ]);

        $result = $creditPacks->list();

        $this->assertIsArray($result->data);
        $this->assertCount(2, $result->data);
        $this->assertInstanceOf(CreditPack::class, $result->data[0]);
        $this->assertSame(100, $result->data[0]->credits);
        $this->assertNull($result->data[0]->description);
        $this->assertSame('Bulk pack', $result->data[1]->description);
    }
}
