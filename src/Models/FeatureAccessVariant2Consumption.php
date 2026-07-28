<?php

declare(strict_types=1);

namespace Commet\Models;

abstract class FeatureAccessVariant2Consumption
{
    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return match ($data["model"] ?? null) {
            "metered" => FeatureAccessVariant2ConsumptionVariant1::fromArray($data),
            "credits" => FeatureAccessVariant2ConsumptionVariant2::fromArray($data),
            "balance" => FeatureAccessVariant2ConsumptionVariant3::fromArray($data),
            default => FeatureAccessVariant2ConsumptionVariant1::fromArray($data),
        };
    }
}
