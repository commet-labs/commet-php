<?php

declare(strict_types=1);

namespace Commet\Tests;

use Commet\Enums\FeatureType;
use Commet\HttpClient;
use Commet\Models\FeatureAccess;
use Commet\Models\FeatureLookup;
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
        return new Response(200, ['Content-Type' => 'application/json'], json_encode([
            'success' => true,
            'data' => $data,
        ], JSON_THROW_ON_ERROR));
    }

    public function testListHydratesFeatureAccessWithFloatUsageFields(): void
    {
        $featureAccess = $this->featureAccessWithResponses([
            $this->response([
                [
                    'code' => 'api_calls',
                    'name' => 'API Calls',
                    'type' => 'usage',
                    'allowed' => true,
                    'object' => 'feature_access',
                    'livemode' => false,
                    'current' => 250.5,
                    'included' => 1000,
                    'remaining' => 749.5,
                    'overage_enabled' => true,
                    'overage_unit_price' => 0.01,
                ],
            ]),
        ]);

        $result = $featureAccess->list(customerId: 'cus_1');

        $query = $this->history[0]['request']->getUri()->getQuery();
        $this->assertStringContainsString('customerId=cus_1', $query);

        $this->assertIsArray($result->data);
        $access = $result->data[0];
        $this->assertInstanceOf(FeatureAccess::class, $access);
        $this->assertSame(FeatureType::Usage, $access->type);
        $this->assertTrue($access->allowed);
        $this->assertSame(250.5, $access->current);
        $this->assertSame(749.5, $access->remaining);
        $this->assertTrue($access->overageEnabled);
        $this->assertSame(0.01, $access->overageUnitPrice);
        // Omitted optional fields stay null.
        $this->assertNull($access->unlimited);
    }

    public function testGetSendsCustomerIdParamAndHydratesLookup(): void
    {
        $featureAccess = $this->featureAccessWithResponses([
            $this->response([
                'allowed' => true,
                'object' => 'feature_lookup',
                'livemode' => false,
                'code' => 'api_calls',
                'name' => 'API Calls',
                'type' => 'usage',
                'current' => 50,
                'included' => 1000,
            ]),
        ]);

        $result = $featureAccess->get(code: 'api_calls', customerId: 'cus_1');

        $query = $this->history[0]['request']->getUri()->getQuery();
        $this->assertStringContainsString('customerId=cus_1', $query);
        $this->assertStringNotContainsString('action=', $query);

        $this->assertInstanceOf(FeatureLookup::class, $result->data);
        $this->assertTrue($result->data->allowed);
        $this->assertSame('api_calls', $result->data->code);
        $this->assertSame(FeatureType::Usage, $result->data->type);
    }

    public function testCanUseSendsActionParamAndHydratesLookup(): void
    {
        $featureAccess = $this->featureAccessWithResponses([
            $this->response([
                'allowed' => false,
                'object' => 'feature_lookup',
                'livemode' => false,
                'code' => 'api_calls',
                'name' => 'API Calls',
                'type' => 'usage',
                'remaining' => 0,
                'will_be_charged' => true,
                'reason' => 'limit_reached',
            ]),
        ]);

        $result = $featureAccess->canUse(code: 'api_calls', customerId: 'cus_1');

        $query = $this->history[0]['request']->getUri()->getQuery();
        $this->assertStringContainsString('action=canUse', $query);
        $this->assertStringContainsString('customerId=cus_1', $query);

        $this->assertInstanceOf(FeatureLookup::class, $result->data);
        $this->assertFalse($result->data->allowed);
        $this->assertSame(FeatureType::Usage, $result->data->type);
        $this->assertTrue($result->data->willBeCharged);
        $this->assertSame('limit_reached', $result->data->reason);
    }
}
