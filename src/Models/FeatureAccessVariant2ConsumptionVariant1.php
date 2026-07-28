<?php

declare(strict_types=1);

namespace Commet\Models;

class FeatureAccessVariant2ConsumptionVariant1 extends FeatureAccessVariant2Consumption
{
    public function __construct(
        public readonly string $model,
        public readonly FeatureAccessVariant2ConsumptionVariant1Period $period,
        public readonly float $unitsUsed,
        public readonly float $includedUnits,
        public readonly bool $unlimited,
        public readonly FeatureAccessVariant2ConsumptionVariant1Overage $overage,
        public readonly ?float $remainingUnits = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            model: $data["model"],
            period: FeatureAccessVariant2ConsumptionVariant1Period::fromArray($data["period"]),
            unitsUsed: $data["units_used"],
            includedUnits: $data["included_units"],
            unlimited: $data["unlimited"],
            overage: FeatureAccessVariant2ConsumptionVariant1Overage::fromArray($data["overage"]),
            remainingUnits: $data["remaining_units"] ?? null,
        );
    }
}
