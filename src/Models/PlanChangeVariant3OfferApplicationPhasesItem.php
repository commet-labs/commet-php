<?php

declare(strict_types=1);

namespace Commet\Models;

abstract class PlanChangeVariant3OfferApplicationPhasesItem
{
    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return match ($data["type"] ?? null) {
            "percentage" => PlanChangeVariant3OfferApplicationPhasesItemVariant1::fromArray($data),
            "amount_off" => PlanChangeVariant3OfferApplicationPhasesItemVariant2::fromArray($data),
            "fixed_price" => PlanChangeVariant3OfferApplicationPhasesItemVariant3::fromArray($data),
            default => PlanChangeVariant3OfferApplicationPhasesItemVariant1::fromArray($data),
        };
    }
}
