<?php

declare(strict_types=1);

namespace Commet\Tests;

use Commet\HttpClient;
use Commet\Resources\SubscriptionsResource;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class SubscriptionsTest extends TestCase
{
    /** @var list<array<string, mixed>> */
    private array $history = [];

    /**
     * @param list<Response> $responses
     */
    private function subscriptionsWithResponses(array $responses): SubscriptionsResource
    {
        $stack = HandlerStack::create(new MockHandler($responses));
        $this->history = [];
        $stack->push(Middleware::history($this->history));
        $http = new HttpClient('ck_test_123', handler: $stack);
        return new SubscriptionsResource($http);
    }

    /** @return array<string, mixed> */
    private function sentBody(int $index = 0): array
    {
        return json_decode((string) $this->history[$index]['request']->getBody(), true);
    }

    private function changePlanResponse(): Response
    {
        return new Response(200, ['Content-Type' => 'application/json'], json_encode([
            'success' => true,
            'data' => ['checkout_url' => 'https://commet.co/checkout/abc'],
        ], JSON_THROW_ON_ERROR));
    }

    private function createResponse(): Response
    {
        return new Response(200, ['Content-Type' => 'application/json'], json_encode([
            'success' => true,
            'data' => [
                'id' => 'sub_123',
                'object' => 'subscription',
                'livemode' => false,
                'customerId' => 'cus_123',
                'name' => 'Pro',
                'status' => 'active',
                'startDate' => '2026-06-03',
                'billingDayOfMonth' => 1,
                'createdAt' => '2026-06-03T00:00:00Z',
                'updatedAt' => '2026-06-03T00:00:00Z',
            ],
        ], JSON_THROW_ON_ERROR));
    }

    public function testChangePlanSendsSuccessUrlAsCamelCase(): void
    {
        $subscriptions = $this->subscriptionsWithResponses([$this->changePlanResponse()]);

        $subscriptions->changePlan(
            subscriptionId: 'sub_123',
            newPlanId: 'plan_456',
            successUrl: 'https://app.example.com/done',
        );

        $body = $this->sentBody();
        $this->assertSame('https://app.example.com/done', $body['successUrl']);
        $this->assertArrayNotHasKey('success_url', $body);
    }

    public function testCreateSendsCustomIntroOfferAsNestedCamelCase(): void
    {
        $subscriptions = $this->subscriptionsWithResponses([$this->createResponse()]);

        $subscriptions->create(
            customerId: 'cus_123',
            planCode: 'pro',
            customIntroOffer: [
                'discount_type' => 'percentage',
                'discount_value' => 1000,
                'duration_cycles' => 3,
            ],
        );

        $body = $this->sentBody();
        $this->assertArrayHasKey('customIntroOffer', $body);
        $this->assertArrayNotHasKey('custom_intro_offer', $body);

        $offer = $body['customIntroOffer'];
        $this->assertSame('percentage', $offer['discountType']);
        $this->assertSame(1000, $offer['discountValue']);
        $this->assertSame(3, $offer['durationCycles']);
        $this->assertArrayNotHasKey('discount_type', $offer);
        $this->assertArrayNotHasKey('discount_value', $offer);
        $this->assertArrayNotHasKey('duration_cycles', $offer);
    }
}
