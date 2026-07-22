<?php

declare(strict_types=1);

namespace Commet\Tests;

use Commet\HttpClient;
use Commet\Models\TestClock;
use Commet\Models\TestClockBilling;
use Commet\Resources\TestClockResource;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class TestClockTest extends TestCase
{
    /** @var list<array<string, mixed>> */
    private array $history = [];

    /**
     * @param list<Response> $responses
     */
    private function testClockWithResponses(array $responses): TestClockResource
    {
        $stack = HandlerStack::create(new MockHandler($responses));
        $this->history = [];
        $stack->push(Middleware::history($this->history));
        $http = new HttpClient('ck_test_123', handler: $stack);
        return new TestClockResource($http);
    }

    /** @return array<string, mixed> */
    private function sentBody(int $index = 0): array
    {
        return json_decode((string) $this->history[$index]['request']->getBody(), true);
    }

    private function response(array $data): Response
    {
        return new Response(200, ['Content-Type' => 'application/json'], json_encode([
            'success' => true,
            'data' => $data,
        ], JSON_THROW_ON_ERROR));
    }

    public function testGetHydratesClockStateFromSnakeCaseWire(): void
    {
        $clock = $this->testClockWithResponses([
            $this->response([
                'is_active' => true,
                'now' => '2026-06-08T12:00:00Z',
                'object' => 'test_clock',
                'livemode' => false,
                'simulated_time' => '2026-07-01T00:00:00Z',
            ]),
        ]);

        $result = $clock->get();

        $this->assertSame('GET', $this->history[0]['request']->getMethod());
        $this->assertInstanceOf(TestClock::class, $result->data);
        $this->assertTrue($result->data->isActive);
        $this->assertSame('2026-07-01T00:00:00Z', $result->data->simulatedTime);
    }

    public function testGetNullSimulatedTimeWireMapsToNullProperty(): void
    {
        $clock = $this->testClockWithResponses([
            $this->response([
                'is_active' => false,
                'now' => '2026-06-08T12:00:00Z',
                'object' => 'test_clock',
                'livemode' => false,
                'simulated_time' => null,
            ]),
        ]);

        $result = $clock->get();

        $this->assertInstanceOf(TestClock::class, $result->data);
        $this->assertFalse($result->data->isActive);
        $this->assertNull($result->data->simulatedTime);
    }

    public function testAdvanceSendsAdvanceDaysAsCamelCase(): void
    {
        $clock = $this->testClockWithResponses([
            $this->response([
                'is_active' => true,
                'now' => '2026-06-15T00:00:00Z',
                'object' => 'test_clock',
                'livemode' => false,
            ]),
        ]);

        $clock->advance(advanceDays: 7);

        $body = $this->sentBody();
        $this->assertSame(7, $body['advanceDays']);
        $this->assertArrayNotHasKey('advance_days', $body);
        $this->assertArrayNotHasKey('frozenTime', $body);
    }

    public function testAdvanceSendsFrozenTimeAndOmitsAdvanceDays(): void
    {
        $clock = $this->testClockWithResponses([
            $this->response([
                'is_active' => true,
                'now' => '2026-07-01T00:00:00Z',
                'object' => 'test_clock',
                'livemode' => false,
            ]),
        ]);

        $clock->advance(frozenTime: '2026-07-01T00:00:00Z');

        $body = $this->sentBody();
        $this->assertSame('2026-07-01T00:00:00Z', $body['frozenTime']);
        $this->assertArrayNotHasKey('advanceDays', $body);
        $this->assertArrayNotHasKey('frozen_time', $body);
    }

    public function testProcessBillingPostsWithNoBodyAndHydratesCounts(): void
    {
        $clock = $this->testClockWithResponses([
            $this->response([
                'customers_found' => 12,
                'enqueued' => 11,
                'failed' => 1,
                'dunning_retried' => 2,
                'dunning_failed' => 3,
                'object' => 'test_clock_billing',
                'livemode' => false,
            ]),
        ]);

        $result = $clock->processBilling();

        $request = $this->history[0]['request'];
        $this->assertSame('POST', $request->getMethod());
        // No-param POST must not send a JSON body.
        $this->assertSame('', (string) $request->getBody());

        $this->assertInstanceOf(TestClockBilling::class, $result->data);
        $this->assertSame(12, $result->data->customersFound);
        $this->assertSame(11, $result->data->enqueued);
        $this->assertSame(1, $result->data->failed);
        $this->assertSame(2, $result->data->dunningRetried);
        $this->assertSame(3, $result->data->dunningFailed);
    }
}
