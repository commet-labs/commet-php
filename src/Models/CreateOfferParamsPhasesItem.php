<?php

declare(strict_types=1);

namespace Commet\Models;

abstract class CreateOfferParamsPhasesItem
{
    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return match ($data["type"] ?? null) {
            "free_trial" => CreateOfferParamsPhasesItemVariant1::fromArray($data),
            "percentage" => CreateOfferParamsPhasesItemVariant2::fromArray($data),
            "amount_off" => CreateOfferParamsPhasesItemVariant3::fromArray($data),
            "fixed_price" => CreateOfferParamsPhasesItemVariant4::fromArray($data),
            default => CreateOfferParamsPhasesItemVariant1::fromArray($data),
        };
    }
}
