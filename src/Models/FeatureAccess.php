<?php

declare(strict_types=1);

namespace Commet\Models;

use Commet\Enums\FeatureType;

class FeatureAccess
{
    public function __construct(
        public readonly string $code,
        public readonly string $name,
        public readonly FeatureType $type,
        public readonly bool $allowed,
        public readonly string $object,
        public readonly bool $livemode,
        public readonly ?bool $enabled = null,
        public readonly ?float $current = null,
        public readonly ?float $included = null,
        public readonly ?float $remaining = null,
        public readonly ?float $overageQuantity = null,
        public readonly ?float $overageUnitPrice = null,
        public readonly ?bool $unlimited = null,
        public readonly ?bool $overageEnabled = null,
        public readonly ?float $billedQuantity = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            code: $data["code"],
            name: $data["name"],
            type: FeatureType::from($data["type"]),
            allowed: $data["allowed"],
            object: $data["object"],
            livemode: $data["livemode"],
            enabled: $data["enabled"] ?? null,
            current: $data["current"] ?? null,
            included: $data["included"] ?? null,
            remaining: $data["remaining"] ?? null,
            overageQuantity: $data["overage_quantity"] ?? null,
            overageUnitPrice: $data["overage_unit_price"] ?? null,
            unlimited: $data["unlimited"] ?? null,
            overageEnabled: $data["overage_enabled"] ?? null,
            billedQuantity: $data["billed_quantity"] ?? null,
        );
    }
}
