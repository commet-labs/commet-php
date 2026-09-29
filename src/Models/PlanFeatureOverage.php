<?php

declare(strict_types=1);

namespace Commet\Models;

class PlanFeatureOverage implements \JsonSerializable
{
    public function __construct(
        public readonly bool $enabled,
        public readonly int $unitPrice,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["enabled"] = $this->enabled;
        $values["unitPrice"] = $this->unitPrice;
        return (object) $values;
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            enabled: $data["enabled"],
            unitPrice: $data["unit_price"],
        );
    }
}
