<?php

declare(strict_types=1);

namespace Commet\Models;

class WebhookFeatureAccess
{
    public function __construct(
        public readonly string $code,
        public readonly string $name,
        public readonly string $type,
        public readonly bool $allowed,
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
            type: $data["type"],
            allowed: $data["allowed"],
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
