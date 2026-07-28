<?php

declare(strict_types=1);

namespace Commet\Models;

class FeatureAccessVariant2ConsumptionVariant3 extends FeatureAccessVariant2Consumption
{
    public function __construct(
        public readonly string $model,
        public readonly FeatureAccessVariant2ConsumptionVariant3Period $period,
        public readonly float $unitsUsed,
        public readonly FeatureAccessVariant2ConsumptionVariant3Spent $spent,
        public readonly ?int $availableUnits = null,
        public readonly ?FeatureAccessVariant2ConsumptionVariant3UnitPrice $unitPrice = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            model: $data["model"],
            period: FeatureAccessVariant2ConsumptionVariant3Period::fromArray($data["period"]),
            unitsUsed: $data["units_used"],
            spent: FeatureAccessVariant2ConsumptionVariant3Spent::fromArray($data["spent"]),
            availableUnits: $data["available_units"] ?? null,
            unitPrice: isset($data["unit_price"]) ? FeatureAccessVariant2ConsumptionVariant3UnitPrice::fromArray($data["unit_price"]) : null,
        );
    }
}
