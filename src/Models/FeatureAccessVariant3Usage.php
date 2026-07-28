<?php

declare(strict_types=1);

namespace Commet\Models;

class FeatureAccessVariant3Usage
{
    public function __construct(
        public readonly FeatureAccessVariant3UsagePeriod $period,
        public readonly float $unitsUsed,
        public readonly float $includedUnits,
        public readonly bool $unlimited,
        public readonly FeatureAccessVariant3UsageOverage $overage,
        public readonly ?float $remainingUnits = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            period: FeatureAccessVariant3UsagePeriod::fromArray($data["period"]),
            unitsUsed: $data["units_used"],
            includedUnits: $data["included_units"],
            unlimited: $data["unlimited"],
            overage: FeatureAccessVariant3UsageOverage::fromArray($data["overage"]),
            remainingUnits: $data["remaining_units"] ?? null,
        );
    }
}
