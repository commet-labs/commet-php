<?php

declare(strict_types=1);

namespace Commet\Models;

use Commet\Enums\FeatureType;

class PlanFeature
{
    public function __construct(
        public readonly string $code,
        public readonly string $name,
        public readonly FeatureType $type,
        public readonly ?string $unitName = null,
        public readonly ?bool $enabled = null,
        public readonly ?int $includedAmount = null,
        public readonly ?bool $unlimited = null,
        public readonly ?bool $overageEnabled = null,
        public readonly ?int $overageUnitPrice = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            code: $data['code'],
            name: $data['name'],
            type: FeatureType::from($data['type']),
            unitName: $data['unit_name'] ?? null,
            enabled: $data['enabled'] ?? null,
            includedAmount: $data['included_amount'] ?? null,
            unlimited: $data['unlimited'] ?? null,
            overageEnabled: $data['overage_enabled'] ?? null,
            overageUnitPrice: $data['overage_unit_price'] ?? null,
        );
    }
}
