<?php

declare(strict_types=1);

namespace Commet\Models;

class FeatureAccessVariant4Usage
{
    public function __construct(
        public readonly FeatureAccessVariant4UsagePeriod $period,
        public readonly float $unitsUsed,
        public readonly float $includedUnits,
        public readonly bool $unlimited,
        public readonly FeatureAccessVariant4UsageOverage $overage,
        public readonly float $billedUnits,
        public readonly ?float $remainingUnits = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            period: FeatureAccessVariant4UsagePeriod::fromArray($data["period"]),
            unitsUsed: $data["units_used"],
            includedUnits: $data["included_units"],
            unlimited: $data["unlimited"],
            overage: FeatureAccessVariant4UsageOverage::fromArray($data["overage"]),
            billedUnits: $data["billed_units"],
            remainingUnits: $data["remaining_units"] ?? null,
        );
    }
}
