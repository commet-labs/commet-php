<?php

declare(strict_types=1);

namespace Commet\Models;

use Commet\Enums\FeatureType;

class FeatureLookup
{
    public function __construct(
        public readonly bool $allowed,
        public readonly string $object,
        public readonly bool $livemode,
        public readonly ?string $code = null,
        public readonly ?string $name = null,
        public readonly ?FeatureType $type = null,
        public readonly ?bool $enabled = null,
        public readonly ?float $current = null,
        public readonly ?float $included = null,
        public readonly ?float $remaining = null,
        public readonly ?float $overageQuantity = null,
        public readonly ?float $overageUnitPrice = null,
        public readonly ?bool $unlimited = null,
        public readonly ?bool $overageEnabled = null,
        public readonly ?float $billedQuantity = null,
        public readonly ?bool $willBeCharged = null,
        public readonly ?string $reason = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            allowed: $data["allowed"],
            object: $data["object"],
            livemode: $data["livemode"],
            code: $data["code"] ?? null,
            name: $data["name"] ?? null,
            type: isset($data["type"]) ? FeatureType::from($data["type"]) : null,
            enabled: $data["enabled"] ?? null,
            current: $data["current"] ?? null,
            included: $data["included"] ?? null,
            remaining: $data["remaining"] ?? null,
            overageQuantity: $data["overage_quantity"] ?? null,
            overageUnitPrice: $data["overage_unit_price"] ?? null,
            unlimited: $data["unlimited"] ?? null,
            overageEnabled: $data["overage_enabled"] ?? null,
            billedQuantity: $data["billed_quantity"] ?? null,
            willBeCharged: $data["will_be_charged"] ?? null,
            reason: $data["reason"] ?? null,
        );
    }
}
