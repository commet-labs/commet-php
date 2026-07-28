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
            "free_trial" => OfferPhasesItemVariant1::fromArray($data),
            "percentage" => OfferPhasesItemVariant2::fromArray($data),
            "amount_off" => OfferPhasesItemVariant3::fromArray($data),
            "fixed_price" => OfferPhasesItemVariant4::fromArray($data),
            default => OfferPhasesItemVariant1::fromArray($data),
        };
    }
}
