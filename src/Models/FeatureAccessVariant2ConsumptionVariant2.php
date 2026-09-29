<?php

declare(strict_types=1);

namespace Commet\Models;

class FeatureAccessVariant2ConsumptionVariant2 extends FeatureAccessVariant2Consumption implements \JsonSerializable
{
    public function __construct(
        public readonly string $model,
        public readonly FeatureAccessVariant2ConsumptionVariant2Period $period,
        public readonly float $unitsUsed,
        public readonly int $creditsPerUnit,
        public readonly float $creditsConsumed,
        public readonly int $availableUnits,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["model"] = $this->model;
        $values["period"] = $this->period;
        $values["unitsUsed"] = $this->unitsUsed;
        $values["creditsPerUnit"] = $this->creditsPerUnit;
        $values["creditsConsumed"] = $this->creditsConsumed;
        $values["availableUnits"] = $this->availableUnits;
        return (object) $values;
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            model: $data["model"],
            period: FeatureAccessVariant2ConsumptionVariant2Period::fromArray($data["period"]),
            unitsUsed: $data["units_used"],
            creditsPerUnit: $data["credits_per_unit"],
            creditsConsumed: $data["credits_consumed"],
            availableUnits: $data["available_units"],
        );
    }
}
