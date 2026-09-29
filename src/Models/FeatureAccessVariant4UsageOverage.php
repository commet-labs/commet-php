<?php

declare(strict_types=1);

namespace Commet\Models;

class FeatureAccessVariant4UsageOverage implements \JsonSerializable
{
    public function __construct(
        public readonly bool $enabled,
        public readonly float $units,
        public readonly ?FeatureAccessVariant4UsageOverageUnitPrice $unitPrice = null,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["enabled"] = $this->enabled;
        $values["units"] = $this->units;
        if ($this->unitPrice !== null) {
            $values["unitPrice"] = $this->unitPrice;
        }
        return (object) $values;
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            enabled: $data["enabled"],
            units: $data["units"],
            unitPrice: isset($data["unit_price"]) ? FeatureAccessVariant4UsageOverageUnitPrice::fromArray($data["unit_price"]) : null,
        );
    }
}
