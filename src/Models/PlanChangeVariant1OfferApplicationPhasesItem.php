<?php

declare(strict_types=1);

namespace Commet\Models;

abstract class PlanChangeVariant1OfferApplicationPhasesItem
{
    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return match ($data["type"] ?? null) {
            "free_trial" => PlanChangeVariant1OfferApplicationPhasesItemVariant1::fromArray($data),
            "percentage" => PlanChangeVariant1OfferApplicationPhasesItemVariant2::fromArray($data),
            "amount_off" => PlanChangeVariant1OfferApplicationPhasesItemVariant3::fromArray($data),
            "fixed_price" => PlanChangeVariant1OfferApplicationPhasesItemVariant4::fromArray($data),
            default => PlanChangeVariant1OfferApplicationPhasesItemVariant1::fromArray($data),
        };
    }
}
