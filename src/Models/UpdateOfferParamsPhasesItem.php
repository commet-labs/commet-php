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
            "percentage" => UpdateOfferParamsPhasesItemVariant1::fromArray($data),
            "amount_off" => UpdateOfferParamsPhasesItemVariant2::fromArray($data),
            "fixed_price" => UpdateOfferParamsPhasesItemVariant3::fromArray($data),
            default => UpdateOfferParamsPhasesItemVariant1::fromArray($data),
        };
    }
}
