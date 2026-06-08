<?php

declare(strict_types=1);

namespace Commet\Tests;

use Commet\Enums\BillingInterval;
use Commet\Enums\ConsumptionModel;
use Commet\HttpClient;
use Commet\Models\Plan;
use Commet\Models\PlanPrice;
use Commet\Models\PlanRegionalPricing;
use Commet\Models\PlanRegionalPricingResult;
use Commet\Resources\PlansResource;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class PlansTest extends TestCase
{
    /** @var list<array<string, mixed>> */
    private array $history = [];

    /**
     * @param list<Response> $responses
     */
    private function plansWithResponses(array $responses): PlansResource
    {
        $stack = HandlerStack::create(new MockHandler($responses));
        $this->history = [];
        $stack->push(Middleware::history($this->history));
        $http = new HttpClient('ck_test_123', handler: $stack);
        return new PlansResource($http);
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

    public function testCreateSerializesConsumptionModelEnumToWireString(): void
    {
        $plans = $this->plansWithResponses([
            $this->response([
                'id' => 'plan_1',
                'name' => 'Pro',
                'code' => 'pro',
                'is_public' => true,
                'is_default' => false,
                'is_free' => false,
                'sort_order' => 1,
                'created_at' => '2026-06-08T00:00:00Z',
                'updated_at' => '2026-06-08T00:00:00Z',
                'object' => 'plan',
                'livemode' => false,
                'consumption_model' => 'metered',
            ]),
        ]);

        $result = $plans->create(
            name: 'Pro',
            code: 'pro',
            consumptionModel: ConsumptionModel::Metered,
            isPublic: true,
        );

        $body = $this->sentBody();
        // Backed enum must serialize to its wire string, camelCased key.
        $this->assertSame('metered', $body['consumptionModel']);
        $this->assertTrue($body['isPublic']);
        $this->assertArrayNotHasKey('consumption_model', $body);

        // Response hydrates enum from wire string.
        $this->assertInstanceOf(Plan::class, $result->data);
        $this->assertSame(ConsumptionModel::Metered, $result->data->consumptionModel);
    }

    public function testAddPriceSerializesBillingIntervalEnumAndNestedIntroOffer(): void
    {
        $plans = $this->plansWithResponses([
            $this->response([
                'id' => 'price_1',
                'plan_id' => 'plan_1',
                'billing_interval' => 'yearly',
                'price' => 99000,
                'is_default' => true,
                'trial_days' => 14,
                'created_at' => '2026-06-08T00:00:00Z',
                'updated_at' => '2026-06-08T00:00:00Z',
                'object' => 'plan_price',
                'livemode' => false,
                'included_credits' => 500,
                'intro_offer' => [
                    'discount_type' => 'percentage',
                    'discount_value' => 2000,
                    'duration_cycles' => 2,
                ],
            ]),
        ]);

        $result = $plans->addPrice(
            id: 'plan_1',
            billingInterval: BillingInterval::Yearly,
            price: 99000,
            trialDays: 14,
            isDefault: true,
            introOffer: [
                'discount_type' => 'percentage',
                'discount_value' => 2000,
                'duration_cycles' => 2,
            ],
        );

        $body = $this->sentBody();
        $this->assertSame('yearly', $body['billingInterval']);
        $this->assertSame(99000, $body['price']);
        $this->assertSame(14, $body['trialDays']);
        // Nested intro offer keys converted recursively to camelCase.
        $this->assertSame('percentage', $body['introOffer']['discountType']);
        $this->assertSame(2000, $body['introOffer']['discountValue']);
        $this->assertSame(2, $body['introOffer']['durationCycles']);
        $this->assertArrayNotHasKey('intro_offer', $body);
        $this->assertArrayNotHasKey('discount_type', $body['introOffer']);

        // Response hydration: enum + nested intro offer preserved as snake_case array.
        $this->assertInstanceOf(PlanPrice::class, $result->data);
        $this->assertSame(BillingInterval::Yearly, $result->data->billingInterval);
        $this->assertSame(500, $result->data->includedCredits);
        $this->assertIsArray($result->data->introOffer);
        $this->assertSame('percentage', $result->data->introOffer['discount_type']);
        $this->assertNull($result->data->includedBalance);
    }

    public function testSetRegionalPricesSendsOverridesArrayWithCamelCaseKeys(): void
    {
        $plans = $this->plansWithResponses([
            $this->response([
                'price_id' => 'price_1',
                'overrides' => [
                    ['currency' => 'EUR', 'price' => 89000],
                ],
                'object' => 'plan_regional_pricing',
                'livemode' => false,
            ]),
        ]);

        $result = $plans->setRegionalPrices(
            id: 'plan_1',
            priceId: 'price_1',
            overrides: [
                ['currency' => 'EUR', 'price' => 89000, 'included_credits' => 400],
                ['currency' => 'GBP', 'price' => 79000],
            ],
        );

        $body = $this->sentBody();
        // List of objects: keys inside each object are converted, list stays indexed.
        $this->assertCount(2, $body['overrides']);
        $this->assertSame('EUR', $body['overrides'][0]['currency']);
        $this->assertSame(400, $body['overrides'][0]['includedCredits']);
        $this->assertArrayNotHasKey('included_credits', $body['overrides'][0]);

        $this->assertInstanceOf(PlanRegionalPricing::class, $result->data);
        $this->assertSame('price_1', $result->data->priceId);
        $this->assertSame('EUR', $result->data->overrides[0]['currency']);
    }

    public function testSetRegionalPricingSendsExchangeRateAsCamelCaseFloat(): void
    {
        $plans = $this->plansWithResponses([
            $this->response([
                'plan_id' => 'plan_1',
                'currency' => 'EUR',
                'exchange_rate' => 0.92,
                'prices_configured' => 1,
                'features_configured' => 2,
                'object' => 'plan_regional_pricing_result',
                'livemode' => false,
            ]),
        ]);

        $result = $plans->setRegionalPricing(
            id: 'plan_1',
            currency: 'EUR',
            exchangeRate: 0.92,
        );

        $body = $this->sentBody();
        $this->assertSame('EUR', $body['currency']);
        $this->assertSame(0.92, $body['exchangeRate']);
        $this->assertArrayNotHasKey('exchange_rate', $body);
        $this->assertArrayNotHasKey('prices', $body);

        $this->assertInstanceOf(PlanRegionalPricingResult::class, $result->data);
        $this->assertSame(0.92, $result->data->exchangeRate);
        $this->assertSame(2, $result->data->featuresConfigured);
    }

    public function testListHydratesPlansWithNestedPricesAndFeatures(): void
    {
        $plans = $this->plansWithResponses([
            $this->response([
                [
                    'id' => 'plan_1',
                    'name' => 'Pro',
                    'code' => 'pro',
                    'is_public' => true,
                    'is_default' => false,
                    'is_free' => false,
                    'sort_order' => 1,
                    'created_at' => '2026-06-08T00:00:00Z',
                    'updated_at' => '2026-06-08T00:00:00Z',
                    'object' => 'plan',
                    'livemode' => false,
                    'prices' => [
                        ['billing_interval' => 'monthly', 'price' => 9900],
                    ],
                    'features' => [
                        ['code' => 'api_calls', 'included_amount' => 1000],
                    ],
                ],
            ]),
        ]);

        $result = $plans->list();

        $this->assertIsArray($result->data);
        $this->assertCount(1, $result->data);
        $plan = $result->data[0];
        $this->assertInstanceOf(Plan::class, $plan);
        // Nested collections are preserved as snake_case arrays (not re-mapped models).
        $this->assertSame(9900, $plan->prices[0]['price']);
        $this->assertSame('monthly', $plan->prices[0]['billing_interval']);
        $this->assertSame('api_calls', $plan->features[0]['code']);
        $this->assertSame(1000, $plan->features[0]['included_amount']);
        $this->assertNull($plan->consumptionModel);
    }
}
