<?php

declare(strict_types=1);

namespace Commet\Tests;

use Commet\Enums\BillingInterval;
use Commet\Enums\ConsumptionModel;
use Commet\Enums\FeatureType;
use Commet\Enums\SubscriptionStatus;
use Commet\Enums\TransactionStatus;
use Commet\Enums\UsageCheckDenialReason;
use Commet\Models\CreditPack;
use Commet\Models\Customer;
use Commet\Models\Feature;
use Commet\Models\Plan;
use Commet\Models\SeatBalance;
use Commet\Models\SeatEvent;
use Commet\Models\Subscription;
use Commet\Models\Transaction;
use Commet\Models\UsageCheckResult;
use Commet\Models\UsageEvent;
use Commet\Models\UsageQuota;
use Commet\Models\UsageQuotaEvent;
use PHPUnit\Framework\TestCase;

class ModelsTest extends TestCase
{
    public function testCustomerFromArray(): void
    {
        $customer = Customer::fromArray([
            'id' => 'cus_123',
            'email' => 'test@example.com',
            'created_at' => '2024-01-01T00:00:00Z',
            'updated_at' => '2024-01-02T00:00:00Z',
            'object' => 'customer',
            'livemode' => false,
            'external_id' => 'ext_1',
            'full_name' => 'John Doe',
        ]);

        $this->assertSame('cus_123', $customer->id);
        $this->assertSame('test@example.com', $customer->email);
        $this->assertSame('ext_1', $customer->externalId);
        $this->assertSame('John Doe', $customer->fullName);
        $this->assertNull($customer->timezone);
        $this->assertNull($customer->metadata);
    }

    public function testFeatureFromArray(): void
    {
        $feature = Feature::fromArray([
            'id' => 'feat_1',
            'name' => 'API Calls',
            'code' => 'api_calls',
            'type' => 'usage',
            'created_at' => '2024-01-01T00:00:00Z',
            'updated_at' => '2024-01-01T00:00:00Z',
            'object' => 'feature',
            'livemode' => false,
            'unit_name' => 'call',
        ]);

        $this->assertSame('api_calls', $feature->code);
        $this->assertSame(FeatureType::Usage, $feature->type);
        $this->assertSame('call', $feature->unitName);
    }

    public function testSubscriptionFromArray(): void
    {
        $subscription = Subscription::fromArray([
            'id' => 'sub_123',
            'customer_id' => 'cus_456',
            'plan' => ['id' => 'plan_pro', 'name' => 'Pro'],
            'name' => 'Pro Subscription',
            'status' => 'active',
            'cancel_at_period_end' => false,
            'start_date' => '2024-01-01T00:00:00Z',
            'created_at' => '2024-01-01T00:00:00Z',
            'updated_at' => '2024-01-02T00:00:00Z',
            'object' => 'subscription',
            'livemode' => false,
            'billing_interval' => 'monthly',
            'consumption_model' => 'metered',
            'checkout_url' => 'https://checkout.example.com/abc',
        ]);

        $this->assertSame('sub_123', $subscription->id);
        $this->assertSame(SubscriptionStatus::Active, $subscription->status);
        $this->assertSame(BillingInterval::Monthly, $subscription->billingInterval);
        $this->assertSame(ConsumptionModel::Metered, $subscription->consumptionModel);
        $this->assertSame(['id' => 'plan_pro', 'name' => 'Pro'], $subscription->plan);
        $this->assertSame('https://checkout.example.com/abc', $subscription->checkoutUrl);
        $this->assertNull($subscription->trialEndsAt);
    }

    public function testPlanFromArrayKeepsInlineCollectionsAsArrays(): void
    {
        $plan = Plan::fromArray([
            'id' => 'plan_pro',
            'name' => 'Pro',
            'code' => 'pro',
            'is_public' => true,
            'is_default' => false,
            'is_free' => false,
            'sort_order' => 2,
            'created_at' => '2024-01-01T00:00:00Z',
            'updated_at' => '2024-01-01T00:00:00Z',
            'object' => 'plan',
            'livemode' => false,
            'prices' => [['billing_interval' => 'monthly', 'price' => 9900]],
            'features' => [['code' => 'api_calls', 'name' => 'API Calls']],
        ]);

        $this->assertSame('plan_pro', $plan->id);
        $this->assertIsArray($plan->prices);
        $this->assertSame(9900, $plan->prices[0]['price']);
        $this->assertIsArray($plan->features);
        $this->assertSame('api_calls', $plan->features[0]['code']);
    }

    public function testSeatEventFromArray(): void
    {
        $event = SeatEvent::fromArray([
            'id' => 'se_123',
            'customer_id' => 'cus_789',
            'feature_code' => 'editor',
            'previous_balance' => 5,
            'new_balance' => 8,
            'ts' => '2024-01-15T10:00:00Z',
            'created_at' => '2024-01-15T10:00:00Z',
            'object' => 'seat_event',
            'livemode' => false,
        ]);

        $this->assertSame('se_123', $event->id);
        $this->assertSame('editor', $event->featureCode);
        $this->assertSame(5, $event->previousBalance);
        $this->assertSame(8, $event->newBalance);
    }

    public function testSeatBalanceFromArray(): void
    {
        $balance = SeatBalance::fromArray([
            'current' => 10,
            'as_of' => '2024-01-15T10:00:00Z',
            'object' => 'seat_balance',
            'livemode' => false,
        ]);

        $this->assertSame(10, $balance->current);
        $this->assertSame('2024-01-15T10:00:00Z', $balance->asOf);
    }

    public function testUsageQuotaEventFromArray(): void
    {
        $event = UsageQuotaEvent::fromArray([
            'id' => 'qe_123',
            'customer_id' => 'cus_789',
            'feature_code' => 'tasks',
            'previous_balance' => 4,
            'new_balance' => 5,
            'ts' => '2024-01-15T10:00:00Z',
            'created_at' => '2024-01-15T10:00:00Z',
            'object' => 'usage_quota_event',
            'livemode' => false,
        ]);

        $this->assertSame('qe_123', $event->id);
        $this->assertSame('tasks', $event->featureCode);
        $this->assertSame(4, $event->previousBalance);
        $this->assertSame(5, $event->newBalance);
    }

    public function testUsageQuotaFromArray(): void
    {
        $quota = UsageQuota::fromArray([
            'feature_code' => 'tasks',
            'current' => 5,
            'included' => 10,
            'billed_quantity' => 10,
            'unlimited' => false,
            'overage_enabled' => true,
            'object' => 'usage_quota',
            'livemode' => false,
            'remaining' => 5,
            'as_of' => '2024-01-15T10:00:00Z',
        ]);

        $this->assertSame('tasks', $quota->featureCode);
        $this->assertSame(5.0, $quota->current);
        $this->assertSame(5.0, $quota->remaining);
        $this->assertTrue($quota->overageEnabled);
    }

    public function testUsageQuotaFromArrayUnlimited(): void
    {
        $quota = UsageQuota::fromArray([
            'feature_code' => 'tasks',
            'current' => 5,
            'included' => 0,
            'billed_quantity' => 0,
            'unlimited' => true,
            'overage_enabled' => false,
            'object' => 'usage_quota',
            'livemode' => false,
            'remaining' => null,
            'as_of' => null,
        ]);

        $this->assertTrue($quota->unlimited);
        $this->assertNull($quota->remaining);
        $this->assertNull($quota->asOf);
    }

    public function testCreditPackFromArray(): void
    {
        $pack = CreditPack::fromArray([
            'id' => 'cp_100',
            'name' => '100 Credits',
            'credits' => 100,
            'price' => 999,
            'object' => 'credit_pack',
            'livemode' => false,
            'currency' => 'USD',
            'description' => 'Starter credit pack',
        ]);

        $this->assertSame('cp_100', $pack->id);
        $this->assertSame(100, $pack->credits);
        $this->assertSame(999, $pack->price);
        $this->assertSame('Starter credit pack', $pack->description);
    }

    public function testTransactionFromArray(): void
    {
        $transaction = Transaction::fromArray([
            'id' => 'txn_123',
            'gross_amount' => 10000,
            'subtotal' => 9000,
            'tax_amount' => 1000,
            'currency' => 'USD',
            'status' => 'succeeded',
            'provider' => 'stripe',
            'created_at' => '2024-01-15T10:00:00Z',
            'updated_at' => '2024-01-15T10:00:00Z',
            'object' => 'transaction',
            'livemode' => false,
            'invoice_id' => 'inv_1',
        ]);

        $this->assertSame('txn_123', $transaction->id);
        $this->assertSame(TransactionStatus::Succeeded, $transaction->status);
        $this->assertSame(10000, $transaction->grossAmount);
        $this->assertSame('inv_1', $transaction->invoiceId);
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

    public function testUsageCheckResultFromArray(): void
    {
        $result = UsageCheckResult::fromArray([
            'allowed' => true,
            'consumption_model' => 'metered',
            'feature' => 'api_calls',
            'quantity' => 1,
            'current' => 500,
            'included' => 10000,
            'remaining' => 9500,
            'overage_enabled' => false,
        ]);

        $this->assertTrue($result->allowed);
        $this->assertSame(ConsumptionModel::Metered, $result->consumptionModel);
        $this->assertSame('api_calls', $result->feature);
        $this->assertSame(9500, $result->remaining);
        $this->assertFalse($result->overageEnabled);
        $this->assertNull($result->reason);
    }

    public function testUsageCheckResultDeniedFromArray(): void
    {
        $result = UsageCheckResult::fromArray([
            'allowed' => false,
            'consumption_model' => 'credits',
            'feature' => 'tokens',
            'quantity' => 100,
            'reason' => 'insufficient_credits',
            'message' => 'Not enough credits',
        ]);

        $this->assertFalse($result->allowed);
        $this->assertSame(ConsumptionModel::Credits, $result->consumptionModel);
        $this->assertSame(UsageCheckDenialReason::InsufficientCredits, $result->reason);
        $this->assertSame('Not enough credits', $result->message);
    }
}
