<?php

declare(strict_types=1);

namespace Commet\Models;

class PlanFeatureOverage
{
    public function __construct(
        public readonly bool $enabled,
        public readonly int $unitPrice,
    ) {}

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
