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
            "percentage" => CreateOfferParamsPhasesItemVariant1::fromArray($data),
            "amount_off" => CreateOfferParamsPhasesItemVariant2::fromArray($data),
            "fixed_price" => CreateOfferParamsPhasesItemVariant3::fromArray($data),
            default => CreateOfferParamsPhasesItemVariant1::fromArray($data),
        };
    }
}
