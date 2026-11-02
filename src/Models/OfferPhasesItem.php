<?php

declare(strict_types=1);

namespace Commet\Models;

abstract class OfferPhasesItem
{
    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return match ($data["type"] ?? null) {
            "percentage" => OfferPhasesItemVariant1::fromArray($data),
            "amount_off" => OfferPhasesItemVariant2::fromArray($data),
            "fixed_price" => OfferPhasesItemVariant3::fromArray($data),
            default => OfferPhasesItemVariant1::fromArray($data),
        };
    }
}
