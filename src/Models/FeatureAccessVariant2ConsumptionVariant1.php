<?php

declare(strict_types=1);

namespace Commet\Models;

class FeatureAccessVariant2ConsumptionVariant1 extends FeatureAccessVariant2Consumption implements \JsonSerializable
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

    public function jsonSerialize(): object
    {
        $values = [];
        $values["model"] = $this->model;
        $values["period"] = $this->period;
        $values["unitsUsed"] = $this->unitsUsed;
        $values["includedUnits"] = $this->includedUnits;
        if ($this->remainingUnits !== null) {
            $values["remainingUnits"] = $this->remainingUnits;
        }
        $values["unlimited"] = $this->unlimited;
        $values["overage"] = $this->overage;
        return (object) $values;
    }

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
