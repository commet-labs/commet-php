<?php

declare(strict_types=1);

namespace Commet\Models;

use Commet\Enums\BillingInterval;
use Commet\Enums\ConsumptionModel;
use Commet\Enums\DiscountType;
use Commet\Enums\SubscriptionStatus;

class Subscription
{
    /**
     * @param FeatureSummary[] $features
     */
    public function __construct(
        public readonly string $id,
        public readonly string $object,
        public readonly bool $livemode,
        public readonly string $customerId,
        public readonly string $name,
        public readonly SubscriptionStatus $status,
        public readonly string $startDate,
        public readonly int $billingDayOfMonth,
        public readonly string $createdAt,
        public readonly string $updatedAt,
        public readonly ?string $description = null,
        public readonly ?ConsumptionModel $consumptionModel = null,
        public readonly ?BillingInterval $billingInterval = null,
        public readonly ?string $trialEndsAt = null,
        public readonly ?string $endDate = null,
        public readonly ?string $nextBillingDate = null,
        public readonly ?string $checkoutUrl = null,
        public readonly ?string $planId = null,
        public readonly ?string $planName = null,
        /** @var array{id: string, name: string, base_price: int, billing_interval: string|null}|null */
        public readonly ?array $plan = null,
        /** @var array{start: string, end: string, days_remaining: int}|null */
        public readonly ?array $currentPeriod = null,
        public readonly ?string $currentPeriodStart = null,
        public readonly ?string $currentPeriodEnd = null,
        public readonly array $features = [],
        /** @var array{remaining: int, included: int, purchased: int}|null */
        public readonly ?array $credits = null,
        /** @var array{remaining: int, included: int, currency: string}|null */
        public readonly ?array $balance = null,
        /** @var array{scheduled_at: string, reason: string|null, effective_at: string}|null */
        public readonly ?array $cancellation = null,
        /** @var array{type: string, value: int, name: string|null, ends_at: string|null}|null */
        public readonly ?array $discount = null,
        public readonly ?string $introOfferEndsAt = null,
        public readonly ?DiscountType $introOfferDiscountType = null,
        public readonly ?int $introOfferDiscountValue = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        $features = array_map(
            fn(array $feature) => FeatureSummary::fromArray($feature),
            $data['features'] ?? [],
        );

        return new self(
            id: $data['id'],
            object: $data['object'] ?? 'subscription',
            livemode: $data['livemode'] ?? false,
            customerId: $data['customer_id'],
            name: $data['name'],
            status: SubscriptionStatus::from($data['status']),
            startDate: $data['start_date'],
            billingDayOfMonth: $data['billing_day_of_month'],
            createdAt: $data['created_at'],
            updatedAt: $data['updated_at'],
            description: $data['description'] ?? null,
            consumptionModel: isset($data['consumption_model']) ? ConsumptionModel::from($data['consumption_model']) : null,
            billingInterval: isset($data['billing_interval']) ? BillingInterval::from($data['billing_interval']) : null,
            trialEndsAt: $data['trial_ends_at'] ?? null,
            endDate: $data['end_date'] ?? null,
            nextBillingDate: $data['next_billing_date'] ?? null,
            checkoutUrl: $data['checkout_url'] ?? null,
            planId: $data['plan_id'] ?? null,
            planName: $data['plan_name'] ?? null,
            plan: $data['plan'] ?? null,
            currentPeriod: $data['current_period'] ?? null,
            currentPeriodStart: $data['current_period_start'] ?? null,
            currentPeriodEnd: $data['current_period_end'] ?? null,
            features: $features,
            credits: $data['credits'] ?? null,
            balance: $data['balance'] ?? null,
            cancellation: $data['cancellation'] ?? null,
            discount: $data['discount'] ?? null,
            introOfferEndsAt: $data['intro_offer_ends_at'] ?? null,
            introOfferDiscountType: isset($data['intro_offer_discount_type']) ? DiscountType::from($data['intro_offer_discount_type']) : null,
            introOfferDiscountValue: $data['intro_offer_discount_value'] ?? null,
        );
    }
}
