<?php

declare(strict_types=1);

namespace Commet\Models;

class Subscription
{
    /**
     * @param FeatureSummary[] $features
     */
    public function __construct(
        public readonly string $id,
        public readonly string $customerId,
        public readonly string $name,
        public readonly string $status,
        public readonly string $startDate,
        public readonly int $billingDayOfMonth,
        public readonly string $createdAt,
        public readonly string $updatedAt,
        public readonly ?string $description = null,
        public readonly ?string $billingInterval = null,
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
        public readonly ?string $introOfferEndsAt = null,
        public readonly ?string $introOfferDiscountType = null,
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
            customerId: $data['customer_id'],
            name: $data['name'],
            status: $data['status'],
            startDate: $data['start_date'],
            billingDayOfMonth: $data['billing_day_of_month'],
            createdAt: $data['created_at'],
            updatedAt: $data['updated_at'],
            description: $data['description'] ?? null,
            billingInterval: $data['billing_interval'] ?? null,
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
            introOfferEndsAt: $data['intro_offer_ends_at'] ?? null,
            introOfferDiscountType: $data['intro_offer_discount_type'] ?? null,
            introOfferDiscountValue: $data['intro_offer_discount_value'] ?? null,
        );
    }
}
