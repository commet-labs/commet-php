<?php

declare(strict_types=1);

namespace Commet\Models;

class AddPlanFeatureParamsOverage implements \JsonSerializable
{
    public function __construct(
        public readonly ?bool $enabled = null,
        public readonly ?int $unitPrice = null,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        if ($this->enabled !== null) {
            $values["enabled"] = $this->enabled;
        }
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
            enabled: $data["enabled"] ?? null,
            unitPrice: $data["unit_price"] ?? null,
        );
    }
}
