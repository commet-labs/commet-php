<?php

declare(strict_types=1);

namespace Commet\Models;

use Commet\Enums\BillingInterval;
use Commet\Enums\DiscountType;

class PromoCode
{
    public function __construct(
        public readonly string $id,
        public readonly string $code,
        public readonly DiscountType $discountType,
        public readonly int $discountValue,
        public readonly bool $isActive,
        public readonly int $redemptionCount,
        public readonly string $createdAt,
        public readonly string $updatedAt,
        public readonly string $object,
        public readonly bool $livemode,
        public readonly ?int $durationCycles = null,
        public readonly ?BillingInterval $billingInterval = null,
        public readonly ?int $maxRedemptions = null,
        public readonly ?string $expiresAt = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data["id"],
            code: $data["code"],
            discountType: DiscountType::from($data["discount_type"]),
            discountValue: $data["discount_value"],
            isActive: $data["is_active"],
            redemptionCount: $data["redemption_count"],
            createdAt: $data["created_at"],
            updatedAt: $data["updated_at"],
            object: $data["object"],
            livemode: $data["livemode"],
            durationCycles: $data["duration_cycles"] ?? null,
            billingInterval: isset($data["billing_interval"]) ? BillingInterval::from($data["billing_interval"]) : null,
            maxRedemptions: $data["max_redemptions"] ?? null,
            expiresAt: $data["expires_at"] ?? null,
        );
    }
}
