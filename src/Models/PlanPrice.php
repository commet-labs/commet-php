<?php

declare(strict_types=1);

namespace Commet\Models;

use Commet\Enums\BillingInterval;
use Commet\Enums\DiscountType;

class PlanPrice
{
    public function __construct(
        public readonly string $id,
        public readonly string $planId,
        public readonly BillingInterval $billingInterval,
        public readonly int $price,
        public readonly bool $isDefault,
        public readonly int $trialDays,
        public readonly string $createdAt,
        public readonly string $updatedAt,
        public readonly string $object,
        public readonly bool $livemode,
        public readonly ?int $includedBalance = null,
        public readonly ?int $includedCredits = null,
        /** @var array<string, mixed>|null */
        public readonly ?array $introOffer = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data["id"],
            planId: $data["plan_id"],
            billingInterval: BillingInterval::from($data["billing_interval"]),
            price: $data["price"],
            isDefault: $data["is_default"],
            trialDays: $data["trial_days"],
            createdAt: $data["created_at"],
            updatedAt: $data["updated_at"],
            object: $data["object"],
            livemode: $data["livemode"],
            includedBalance: $data["included_balance"] ?? null,
            includedCredits: $data["included_credits"] ?? null,
            introOffer: $data["intro_offer"] ?? null,
        );
    }
}
