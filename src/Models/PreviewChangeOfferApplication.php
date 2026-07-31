<?php

declare(strict_types=1);

namespace Commet\Models;

class PreviewChangeOfferApplication
{
    public function __construct(
        public readonly string $id,
        public readonly string $offerId,
        public readonly string $name,
        public readonly string $currency,
        public readonly int $subtotal,
        public readonly int $discountAmount,
        public readonly int $total,
        /** @var PreviewChangeOfferApplicationPhasesItem[] */
        public readonly array $phases,
        public readonly PreviewChangeOfferApplicationAppliesTo $appliesTo,
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
            phases: array_map(fn(array $item) => PreviewChangeOfferApplicationPhasesItem::fromArray($item), $data["phases"]),
            appliesTo: PreviewChangeOfferApplicationAppliesTo::fromArray($data["applies_to"]),
        );
    }
}
