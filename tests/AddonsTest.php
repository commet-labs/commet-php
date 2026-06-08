<?php

declare(strict_types=1);

namespace Commet\Tests;

use Commet\Enums\FeatureType;
use Commet\HttpClient;
use Commet\Models\ActiveAddon;
use Commet\Models\Addon;
use Commet\Resources\AddonsResource;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class AddonsTest extends TestCase
{
    /** @var list<array<string, mixed>> */
    private array $history = [];

    /**
     * @param list<Response> $responses
     */
    private function addonsWithResponses(array $responses): AddonsResource
    {
        $stack = HandlerStack::create(new MockHandler($responses));
        $this->history = [];
        $stack->push(Middleware::history($this->history));
        $http = new HttpClient('ck_test_123', handler: $stack);
        return new AddonsResource($http);
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

    public function testCreateSendsSnakeCaseBodyAsCamelCaseAndHydratesAddon(): void
    {
        $addons = $this->addonsWithResponses([
            $this->response([
                'id' => 'addon_1',
                'name' => 'Extra Seats',
                'slug' => 'extra-seats',
                'base_price' => 5000,
                'consumption_model' => 'metered',
                'feature_code' => 'seats',
                'feature_name' => 'Seats',
                'created_at' => '2026-06-08T00:00:00Z',
                'updated_at' => '2026-06-08T00:00:00Z',
                'object' => 'addon',
                'livemode' => false,
                'included_units' => 5,
                'overage_rate' => 200,
            ]),
        ]);

        $result = $addons->create(
            name: 'Extra Seats',
            basePrice: 5000,
            featureId: 'feat_seats',
            consumptionModel: 'metered',
            includedUnits: 5,
            overageRate: 200,
        );

        $body = $this->sentBody();
        $this->assertSame(5000, $body['basePrice']);
        $this->assertSame('feat_seats', $body['featureId']);
        $this->assertSame('metered', $body['consumptionModel']);
        $this->assertSame(5, $body['includedUnits']);
        $this->assertSame(200, $body['overageRate']);
        $this->assertArrayNotHasKey('base_price', $body);
        // creditCost was null -> never sent.
        $this->assertArrayNotHasKey('creditCost', $body);

        $this->assertInstanceOf(Addon::class, $result->data);
        $this->assertSame('extra-seats', $result->data->slug);
        $this->assertSame(5000, $result->data->basePrice);
        $this->assertSame(5, $result->data->includedUnits);
        $this->assertSame(200, $result->data->overageRate);
        $this->assertNull($result->data->creditCost);
    }

    public function testListActiveHydratesFeatureTypeEnum(): void
    {
        $addons = $this->addonsWithResponses([
            $this->response([
                [
                    'slug' => 'extra-seats',
                    'name' => 'Extra Seats',
                    'base_price' => 5000,
                    'feature_code' => 'seats',
                    'feature_name' => 'Seats',
                    'feature_type' => 'seats',
                    'consumption_model' => 'metered',
                    'activated_at' => '2026-06-08T00:00:00Z',
                    'object' => 'active_addon',
                    'livemode' => false,
                ],
            ]),
        ]);

        $result = $addons->listActive(customerId: 'cus_1');

        $query = $this->history[0]['request']->getUri()->getQuery();
        $this->assertStringContainsString('customerId=cus_1', $query);

        $this->assertIsArray($result->data);
        $addon = $result->data[0];
        $this->assertInstanceOf(ActiveAddon::class, $addon);
        $this->assertSame(FeatureType::Seats, $addon->featureType);
        $this->assertSame('extra-seats', $addon->slug);
        $this->assertSame(5000, $addon->basePrice);
    }
}
