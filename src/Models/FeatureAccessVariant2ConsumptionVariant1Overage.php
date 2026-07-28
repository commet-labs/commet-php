<?php

declare(strict_types=1);

namespace Commet\Models;

class FeatureAccessVariant2ConsumptionVariant1Overage
{
    public function __construct(
        public readonly bool $enabled,
        public readonly float $units,
        public readonly ?FeatureAccessVariant2ConsumptionVariant1OverageUnitPrice $unitPrice = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            enabled: $data["enabled"],
            units: $data["units"],
            unitPrice: isset($data["unit_price"]) ? FeatureAccessVariant2ConsumptionVariant1OverageUnitPrice::fromArray($data["unit_price"]) : null,
        );
    }
}
