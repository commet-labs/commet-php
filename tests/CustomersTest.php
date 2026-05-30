<?php

declare(strict_types=1);

namespace Commet\Tests;

use Commet\HttpClient;
use Commet\Resources\CustomersResource;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class CustomersTest extends TestCase
{
    /** @var list<array<string, mixed>> */
    private array $history = [];

    /**
     * @param list<Response> $responses
     */
    private function customersWithResponses(array $responses): CustomersResource
    {
        $stack = HandlerStack::create(new MockHandler($responses));
        $this->history = [];
        $stack->push(Middleware::history($this->history));
        $http = new HttpClient('ck_test_123', handler: $stack);
        return new CustomersResource($http);
    }

    /** @return array<string, mixed> */
    private function sentBody(int $index = 0): array
    {
        return json_decode((string) $this->history[$index]['request']->getBody(), true);
    }

    private function customerResponse(): Response
    {
        return new Response(200, ['Content-Type' => 'application/json'], json_encode([
            'success' => true,
            'data' => [
                'id' => 'cus_x',
                'organization_id' => 'org_1',
                'billing_email' => 'a@b.com',
                'created_at' => '2024-01-01T00:00:00Z',
                'updated_at' => '2024-01-01T00:00:00Z',
            ],
        ], JSON_THROW_ON_ERROR));
    }

    public function testCreateSendsId(): void
    {
        $customers = $this->customersWithResponses([$this->customerResponse()]);

        $customers->create(email: 'a@b.com', id: 'ext_123');

        $body = $this->sentBody();
        $this->assertSame('ext_123', $body['id']);
        $this->assertSame('a@b.com', $body['billingEmail']);
    }

    public function testCreateOmitsIdWhenNull(): void
    {
        $customers = $this->customersWithResponses([$this->customerResponse()]);

        $customers->create(email: 'a@b.com');

        $this->assertArrayNotHasKey('id', $this->sentBody());
    }

    public function testCreateBatchSendsId(): void
    {
        $batch = new Response(200, ['Content-Type' => 'application/json'], json_encode([
            'success' => true,
            'data' => ['successful' => [], 'failed' => []],
        ], JSON_THROW_ON_ERROR));
        $customers = $this->customersWithResponses([$batch]);

        $customers->createBatch([
            ['email' => 'a@b.com', 'id' => 'ext_a'],
            ['email' => 'b@b.com'],
        ]);

        $body = $this->sentBody();
        $this->assertSame('ext_a', $body['customers'][0]['id']);
        $this->assertArrayNotHasKey('id', $body['customers'][1]);
    }
}
