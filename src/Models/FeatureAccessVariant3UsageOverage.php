<?php

declare(strict_types=1);

namespace Commet\Models;

class FeatureAccessVariant3UsageOverage
{
    public function __construct(
        public readonly bool $enabled,
        public readonly float $units,
        public readonly ?FeatureAccessVariant3UsageOverageUnitPrice $unitPrice = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            enabled: $data["enabled"],
            units: $data["units"],
            unitPrice: isset($data["unit_price"]) ? FeatureAccessVariant3UsageOverageUnitPrice::fromArray($data["unit_price"]) : null,
        );
    }
}
