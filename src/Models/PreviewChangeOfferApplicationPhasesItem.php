<?php

declare(strict_types=1);

namespace Commet\Models;

abstract class PreviewChangeOfferApplicationPhasesItem
{
    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return match ($data["type"] ?? null) {
            "percentage" => PreviewChangeOfferApplicationPhasesItemVariant1::fromArray($data),
            "amount_off" => PreviewChangeOfferApplicationPhasesItemVariant2::fromArray($data),
            "fixed_price" => PreviewChangeOfferApplicationPhasesItemVariant3::fromArray($data),
            default => PreviewChangeOfferApplicationPhasesItemVariant1::fromArray($data),
        };
    }
}
