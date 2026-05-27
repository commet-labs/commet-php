<?php

declare(strict_types=1);

namespace Commet\Models;

use Commet\Enums\BillingInterval;

class PlanPriceManage
{
    public function __construct(
        public readonly string $id,
        public readonly string $object,
        public readonly bool $livemode,
        public readonly string $planId,
        public readonly BillingInterval $billingInterval,
        public readonly int $price,
        public readonly bool $isDefault,
        public readonly int $trialDays,
        public readonly bool $introOfferEnabled,
        public readonly string $createdAt,
        public readonly string $updatedAt,
        public readonly ?int $includedBalance = null,
        public readonly ?int $includedCredits = null,
        public readonly ?string $introOfferDiscountType = null,
        public readonly ?int $introOfferDiscountValue = null,
        public readonly ?int $introOfferDurationCycles = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            object: $data['object'] ?? 'plan_price',
            livemode: $data['livemode'] ?? false,
            planId: $data['plan_id'],
            billingInterval: BillingInterval::from($data['billing_interval']),
            price: $data['price'],
            isDefault: $data['is_default'],
            trialDays: $data['trial_days'],
            introOfferEnabled: $data['intro_offer_enabled'],
            createdAt: $data['created_at'],
            updatedAt: $data['updated_at'],
            includedBalance: $data['included_balance'] ?? null,
            includedCredits: $data['included_credits'] ?? null,
            introOfferDiscountType: $data['intro_offer_discount_type'] ?? null,
            introOfferDiscountValue: $data['intro_offer_discount_value'] ?? null,
            introOfferDurationCycles: $data['intro_offer_duration_cycles'] ?? null,
        );
    }
}
