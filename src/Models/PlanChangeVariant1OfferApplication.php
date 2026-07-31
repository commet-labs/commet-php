<?php

declare(strict_types=1);

namespace Commet\Models;

class PlanChangeVariant1OfferApplication
{
    public function __construct(
        public readonly string $id,
        public readonly string $offerId,
        public readonly string $name,
        public readonly string $currency,
        public readonly int $subtotal,
        public readonly int $discountAmount,
        public readonly int $total,
        /** @var PlanChangeVariant1OfferApplicationPhasesItem[] */
        public readonly array $phases,
        public readonly PlanChangeVariant1OfferApplicationAppliesTo $appliesTo,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data["id"],
            offerId: $data["offer_id"],
            name: $data["name"],
            currency: $data["currency"],
            subtotal: $data["subtotal"],
            discountAmount: $data["discount_amount"],
            total: $data["total"],
            phases: array_map(fn(array $item) => PlanChangeVariant1OfferApplicationPhasesItem::fromArray($item), $data["phases"]),
            appliesTo: PlanChangeVariant1OfferApplicationAppliesTo::fromArray($data["applies_to"]),
        );
    }
}
