<?php

declare(strict_types=1);

namespace Commet\Models;

class AddPlanFeatureParamsOverage
{
    public function __construct(
        public readonly ?bool $enabled = null,
        public readonly ?int $unitPrice = null,
    ) {}

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
