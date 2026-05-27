<?php

declare(strict_types=1);

namespace Commet\Models;

use Commet\Enums\DiscountType;

class PromoCode
{
    public function __construct(
        public readonly string $id,
        public readonly string $object,
        public readonly bool $livemode,
        public readonly string $code,
        public readonly DiscountType $discountType,
        public readonly int $discountValue,
        public readonly bool $active,
        public readonly int $redemptionCount,
        public readonly string $createdAt,
        public readonly ?int $durationCycles = null,
        public readonly ?int $maxRedemptions = null,
        public readonly ?string $expiresAt = null,
        public readonly ?string $updatedAt = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            object: $data['object'] ?? 'promo_code',
            livemode: $data['livemode'] ?? false,
            code: $data['code'],
            discountType: DiscountType::from($data['discount_type']),
            discountValue: $data['discount_value'],
            active: $data['active'],
            redemptionCount: $data['redemption_count'],
            createdAt: $data['created_at'],
            durationCycles: $data['duration_cycles'] ?? null,
            maxRedemptions: $data['max_redemptions'] ?? null,
            expiresAt: $data['expires_at'] ?? null,
            updatedAt: $data['updated_at'] ?? null,
        );
    }
}
