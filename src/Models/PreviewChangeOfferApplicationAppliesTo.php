<?php

declare(strict_types=1);

namespace Commet\Models;

abstract class PreviewChangeOfferApplicationAppliesTo
{
    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return match ($data["type"] ?? null) {
            "plan_price" => PreviewChangeOfferApplicationAppliesToVariant1::fromArray($data),
            "addon" => PreviewChangeOfferApplicationAppliesToVariant2::fromArray($data),
            "credit_pack" => PreviewChangeOfferApplicationAppliesToVariant3::fromArray($data),
            default => PreviewChangeOfferApplicationAppliesToVariant1::fromArray($data),
        };
    }
}
