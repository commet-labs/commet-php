<?php

declare(strict_types=1);

namespace Commet\Models;

abstract class UpdateOfferParamsPhasesItem
{
    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return match ($data["type"] ?? null) {
            "free_trial" => UpdateOfferParamsPhasesItemVariant1::fromArray($data),
            "percentage" => UpdateOfferParamsPhasesItemVariant2::fromArray($data),
            "amount_off" => UpdateOfferParamsPhasesItemVariant3::fromArray($data),
            "fixed_price" => UpdateOfferParamsPhasesItemVariant4::fromArray($data),
            default => UpdateOfferParamsPhasesItemVariant1::fromArray($data),
        };
    }
}
