<?php

declare(strict_types=1);

namespace Commet\Tests;

use Commet\HttpClient;
use Commet\Models\FeatureAccessVariant1;
use Commet\Resources\FeatureAccessResource;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class FeatureAccessTest extends TestCase
{
    /** @var list<array<string, mixed>> */
    private array $history = [];

    /**
     * @param list<Response> $responses
     */
    private function featureAccessWithResponses(array $responses): FeatureAccessResource
    {
        $stack = HandlerStack::create(new MockHandler($responses));
        $this->history = [];
        $stack->push(Middleware::history($this->history));
        $http = new HttpClient('ck_test_123', handler: $stack);
        return new FeatureAccessResource($http);
    }

    private function response(mixed $data): Response
    {
        return new Response(
            200,
            ['Content-Type' => 'application/json'],
            json_encode($data, JSON_THROW_ON_ERROR),
        );
    }

    public function testListHydratesFeatureAccess(): void
    {
        $featureAccess = $this->featureAccessWithResponses([
            $this->response([
                'object' => 'list',
                'data' => [[
                    'code' => 'sso',
                    'name' => 'SSO',
                    'type' => 'boolean',
                    'allowed' => true,
                    'enabled' => true,
                    'object' => 'feature',
                    'livemode' => false,
                ]],
                'has_more' => false,
            ]),
        ]);

        $result = $featureAccess->list(customerId: 'cus_1');

        $query = $this->history[0]['request']->getUri()->getQuery();
        $this->assertStringContainsString('customerId=cus_1', $query);
        $this->assertFalse($result->hasMore);
        $this->assertInstanceOf(FeatureAccessVariant1::class, $result->data[0]);
        $this->assertTrue($result->data[0]->allowed);
        $this->assertTrue($result->data[0]->enabled);
    }

    public function testGetSendsCustomerIdAndHydratesLookup(): void
    {
        $featureAccess = $this->featureAccessWithResponses([
            $this->response([
                'code' => 'sso',
                'name' => 'SSO',
                'type' => 'boolean',
                'allowed' => true,
                'enabled' => true,
                'object' => 'feature',
                'livemode' => false,
            ]),
        ]);

        $result = $featureAccess->get(code: 'sso', customerId: 'cus_1');

        $query = $this->history[0]['request']->getUri()->getQuery();
        $this->assertStringContainsString('customerId=cus_1', $query);
        $this->assertStringNotContainsString('action=', $query);
        $this->assertInstanceOf(FeatureAccessVariant1::class, $result);
        $this->assertTrue($result->allowed);
        $this->assertSame('sso', $result->code);
    }
}
