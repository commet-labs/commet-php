<?php

declare(strict_types=1);

namespace Commet\Tests;

use Commet\Models\CanUseResult;
use Commet\Models\CreditPack;
use Commet\Models\Customer;
use Commet\Models\Feature;
use Commet\Models\FeatureAccess;
use Commet\Models\Plan;
use Commet\Models\PlanFeature;
use Commet\Models\PlanPrice;
use Commet\Models\PortalSession;
use Commet\Models\SeatBalance;
use Commet\Models\SeatEvent;
use Commet\Models\Subscription;
use Commet\Models\UsageEvent;
use PHPUnit\Framework\TestCase;

class ModelsTest extends TestCase
{
    public function testCustomerFromArray(): void
    {
        $customer = Customer::fromArray([
            'id' => 'cust_123',
            'organization_id' => 'org_456',
            'billing_email' => 'test@example.com',
            'created_at' => '2024-01-01T00:00:00Z',
            'updated_at' => '2024-01-02T00:00:00Z',
            'full_name' => 'John Doe',
        ]);

        $this->assertSame('cust_123', $customer->id);
        $this->assertSame('org_456', $customer->organizationId);
        $this->assertSame('test@example.com', $customer->billingEmail);
        $this->assertSame('John Doe', $customer->fullName);
        $this->assertNull($customer->domain);
        $this->assertNull($customer->metadata);
    }

    public function testPlanFromArrayWithNestedObjects(): void
    {
        $plan = Plan::fromArray([
            'id' => 'plan_pro',
            'code' => 'pro',
            'name' => 'Pro',
            'description' => 'Professional plan',
            'is_public' => true,
            'is_default' => false,
            'sort_order' => 2,
            'created_at' => '2024-01-01T00:00:00Z',
            'prices' => [
                [
                    'billing_interval' => 'monthly',
                    'price' => 9900,
                    'is_default' => true,
                    'trial_days' => 14,
                ],
            ],
            'features' => [
                [
                    'code' => 'api_calls',
                    'name' => 'API Calls',
                    'type' => 'metered',
                    'unit_name' => 'call',
                    'included_amount' => 10000,
                    'unlimited' => false,
                ],
            ],
        ]);

        $this->assertSame('plan_pro', $plan->id);
        $this->assertSame('Pro', $plan->name);
        $this->assertCount(1, $plan->prices);
        $this->assertInstanceOf(PlanPrice::class, $plan->prices[0]);
        $this->assertSame(9900, $plan->prices[0]->price);
        $this->assertSame(14, $plan->prices[0]->trialDays);
        $this->assertCount(1, $plan->features);
        $this->assertInstanceOf(PlanFeature::class, $plan->features[0]);
        $this->assertSame('api_calls', $plan->features[0]->code);
        $this->assertSame(10000, $plan->features[0]->includedAmount);
    }

    public function testSubscriptionFromArray(): void
    {
        $subscription = Subscription::fromArray([
            'id' => 'sub_123',
            'customer_id' => 'cust_456',
            'name' => 'Pro Subscription',
            'status' => 'active',
            'start_date' => '2024-01-01T00:00:00Z',
            'billing_day_of_month' => 15,
            'created_at' => '2024-01-01T00:00:00Z',
            'updated_at' => '2024-01-02T00:00:00Z',
            'billing_interval' => 'monthly',
            'plan_id' => 'plan_pro',
            'plan_name' => 'Pro',
            'checkout_url' => 'https://checkout.example.com/abc',
        ]);

        $this->assertSame('sub_123', $subscription->id);
        $this->assertSame('active', $subscription->status);
        $this->assertSame(15, $subscription->billingDayOfMonth);
        $this->assertSame('monthly', $subscription->billingInterval);
        $this->assertSame('https://checkout.example.com/abc', $subscription->checkoutUrl);
        $this->assertNull($subscription->trialEndsAt);
    }

    public function testFeatureFromArray(): void
    {
        $feature = Feature::fromArray([
            'code' => 'api_calls',
            'name' => 'API Calls',
            'type' => 'metered',
            'allowed' => true,
            'current' => 500,
            'included' => 10000,
            'remaining' => 9500,
            'unlimited' => false,
        ]);

        $this->assertSame('api_calls', $feature->code);
        $this->assertTrue($feature->allowed);
        $this->assertSame(500, $feature->current);
        $this->assertSame(9500, $feature->remaining);
    }

    public function testFeatureAccessFromArray(): void
    {
        $access = FeatureAccess::fromArray(['allowed' => true]);

        $this->assertTrue($access->allowed);
    }

    public function testCanUseResultFromArray(): void
    {
        $result = CanUseResult::fromArray([
            'allowed' => true,
            'will_be_charged' => false,
            'reason' => 'Within included amount',
        ]);

        $this->assertTrue($result->allowed);
        $this->assertFalse($result->willBeCharged);
        $this->assertSame('Within included amount', $result->reason);
    }

    public function testSeatEventFromArray(): void
    {
        $event = SeatEvent::fromArray([
            'id' => 'se_123',
            'organization_id' => 'org_456',
            'customer_id' => 'cust_789',
            'feature_code' => 'editor',
            'event_type' => 'add',
            'quantity' => 3,
            'new_balance' => 8,
            'ts' => '2024-01-15T10:00:00Z',
            'created_at' => '2024-01-15T10:00:00Z',
            'previous_balance' => 5,
        ]);

        $this->assertSame('se_123', $event->id);
        $this->assertSame('editor', $event->featureCode);
        $this->assertSame('add', $event->eventType);
        $this->assertSame(3, $event->quantity);
        $this->assertSame(8, $event->newBalance);
        $this->assertSame(5, $event->previousBalance);
    }

    public function testSeatBalanceFromArray(): void
    {
        $balance = SeatBalance::fromArray([
            'current' => 10,
            'as_of' => '2024-01-15T10:00:00Z',
        ]);

        $this->assertSame(10, $balance->current);
        $this->assertSame('2024-01-15T10:00:00Z', $balance->asOf);
    }

    public function testCreditPackFromArray(): void
    {
        $pack = CreditPack::fromArray([
            'id' => 'cp_100',
            'name' => '100 Credits',
            'credits' => 100,
            'price' => 999,
            'currency' => 'USD',
            'description' => 'Starter credit pack',
        ]);

        $this->assertSame('cp_100', $pack->id);
        $this->assertSame(100, $pack->credits);
        $this->assertSame(999, $pack->price);
        $this->assertSame('Starter credit pack', $pack->description);
    }

    public function testPortalSessionFromArray(): void
    {
        $session = PortalSession::fromArray([
            'portal_url' => 'https://portal.example.com/session_abc',
            'message' => 'Session created',
        ]);

        $this->assertSame('https://portal.example.com/session_abc', $session->portalUrl);
        $this->assertSame('Session created', $session->message);
    }

    public function testUsageEventFromArray(): void
    {
        $event = UsageEvent::fromArray([
            'id' => 'evt_123',
            'organization_id' => 'org_456',
            'customer_id' => 'cust_789',
            'feature' => 'api_calls',
            'ts' => '2024-01-15T10:00:00Z',
            'created_at' => '2024-01-15T10:00:00Z',
            'idempotency_key' => 'idem_abc',
            'properties' => [
                [
                    'id' => 'prop_1',
                    'usage_event_id' => 'evt_123',
                    'property' => 'model',
                    'value' => 'gpt-4',
                    'created_at' => '2024-01-15T10:00:00Z',
                ],
            ],
        ]);

        $this->assertSame('evt_123', $event->id);
        $this->assertSame('api_calls', $event->feature);
        $this->assertSame('idem_abc', $event->idempotencyKey);
        $this->assertCount(1, $event->properties);
        $this->assertSame('model', $event->properties[0]->property);
        $this->assertSame('gpt-4', $event->properties[0]->value);
    }
}
