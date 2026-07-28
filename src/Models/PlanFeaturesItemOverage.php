<?php

declare(strict_types=1);

namespace Commet\Models;

class PlanFeaturesItemOverage
{
    public function __construct(
        public readonly bool $enabled,
        public readonly ?string $model = null,
        public readonly ?int $unitPrice = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            enabled: $data["enabled"],
            model: $data["model"] ?? null,
            unitPrice: $data["unit_price"] ?? null,
        );
    }
}
