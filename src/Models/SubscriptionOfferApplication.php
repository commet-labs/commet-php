<?php

declare(strict_types=1);

namespace Commet\Models;

class SubscriptionOfferApplication
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly SubscriptionOfferApplicationAppliesTo $appliesTo,
        public readonly string $source,
        public readonly string $status,
        /** @var SubscriptionOfferApplicationPhase[] */
        public readonly array $phases,
        public readonly string $quotedAt,
        public readonly ?string $offerId = null,
        public readonly ?string $currency = null,
        public readonly ?int $subtotal = null,
        public readonly ?int $discountAmount = null,
        public readonly ?int $total = null,
        public readonly ?string $appliedAt = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data["id"],
            name: $data["name"],
            appliesTo: SubscriptionOfferApplicationAppliesTo::fromArray($data["applies_to"]),
            source: $data["source"],
            status: $data["status"],
            phases: array_map(fn(array $item) => SubscriptionOfferApplicationPhase::fromArray($item), $data["phases"]),
            quotedAt: $data["quoted_at"],
            offerId: $data["offer_id"] ?? null,
            currency: $data["currency"] ?? null,
            subtotal: $data["subtotal"] ?? null,
            discountAmount: $data["discount_amount"] ?? null,
            total: $data["total"] ?? null,
            appliedAt: $data["applied_at"] ?? null,
        );
    }
}
