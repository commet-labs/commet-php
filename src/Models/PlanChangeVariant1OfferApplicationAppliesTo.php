<?php

declare(strict_types=1);

namespace Commet\Models;

abstract class PlanChangeVariant1OfferApplicationAppliesTo
{
    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return match ($data["type"] ?? null) {
            "plan_price" => PlanChangeVariant1OfferApplicationAppliesToVariant1::fromArray($data),
            "addon" => PlanChangeVariant1OfferApplicationAppliesToVariant2::fromArray($data),
            "credit_pack" => PlanChangeVariant1OfferApplicationAppliesToVariant3::fromArray($data),
            default => PlanChangeVariant1OfferApplicationAppliesToVariant1::fromArray($data),
        };
    }
}
