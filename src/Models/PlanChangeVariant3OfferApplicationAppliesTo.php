<?php

declare(strict_types=1);

namespace Commet\Models;

abstract class PlanChangeVariant3OfferApplicationAppliesTo
{
    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return match ($data["type"] ?? null) {
            "plan_price" => PlanChangeVariant3OfferApplicationAppliesToVariant1::fromArray($data),
            "addon" => PlanChangeVariant3OfferApplicationAppliesToVariant2::fromArray($data),
            "credit_pack" => PlanChangeVariant3OfferApplicationAppliesToVariant3::fromArray($data),
            default => PlanChangeVariant3OfferApplicationAppliesToVariant1::fromArray($data),
        };
    }
}
