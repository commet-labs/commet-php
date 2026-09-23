<?php

declare(strict_types=1);

namespace Commet\Tests;

use Commet\HttpClient;
use Commet\Resources\ApiKeysResource;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class ApiKeysTest extends TestCase
{
    /** @var list<array<string, mixed>> */
    private array $history = [];

    private function createWithPermissions(?array $permissions): string
    {
        $response = new Response(201, ['Content-Type' => 'application/json'], json_encode([
            'success' => true,
            'data' => [
                'id' => 'key_1', 'name' => 'Example', 'api_key' => 'rk_live_secret',
                'prefix' => 'rk_live_', 'expires_at' => '2027-01-01T00:00:00Z',
                'created_at' => '2026-09-23T00:00:00Z', 'object' => 'api_key', 'livemode' => true,
            ],
        ], JSON_THROW_ON_ERROR));
        $stack = HandlerStack::create(new MockHandler([$response]));
        $this->history = [];
        $stack->push(Middleware::history($this->history));
        $resource = new ApiKeysResource(new HttpClient('ck_test_123', handler: $stack));
        $resource->create(name: 'Example', permissions: $permissions);
        return (string) $this->history[0]['request']->getBody();
    }

    public function testOmittedPermissionsStayOmitted(): void
    {
        $body = json_decode($this->createWithPermissions(null), true, flags: JSON_THROW_ON_ERROR);
        $this->assertArrayNotHasKey('permissions', $body);
    }

    public function testEmptyPermissionsStayAnObject(): void
    {
        $this->assertStringContainsString('"permissions":{}', $this->createWithPermissions([]));
    }

    public function testUnderscoredPermissionResourceStaysLiteral(): void
    {
        $body = json_decode($this->createWithPermissions(['plan_group' => ['read']]), true, flags: JSON_THROW_ON_ERROR);
        $this->assertSame(['plan_group' => ['read']], $body['permissions']);
    }
}
