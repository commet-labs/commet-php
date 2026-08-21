<?php

declare(strict_types=1);

namespace Commet\Tests;

use Commet\HttpClient;
use Commet\Models\TestClock;
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

    private function response(array $data): Response
    {
        return new Response(200, ['Content-Type' => 'application/json'], json_encode($data, JSON_THROW_ON_ERROR));
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
        $this->assertInstanceOf(TestClock::class, $result);
        $this->assertTrue($result->isActive);
        $this->assertSame('2026-07-01T00:00:00Z', $result->simulatedTime);
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

        $this->assertInstanceOf(TestClock::class, $result);
        $this->assertFalse($result->isActive);
        $this->assertNull($result->simulatedTime);
    }
}
