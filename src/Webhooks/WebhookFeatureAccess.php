<?php

declare(strict_types=1);

namespace Commet\Webhooks;

final class WebhookFeatureAccess
{
    public function __construct(
        public readonly string $code,
        public readonly string $name,
        public readonly string $type,
        public readonly bool $allowed,
        public readonly ?bool $enabled,
        public readonly ?float $current,
        public readonly ?float $included,
        public readonly ?float $remaining,
        public readonly ?float $overageQuantity,
        public readonly ?float $overageUnitPrice,
        public readonly ?bool $unlimited,
        public readonly ?bool $overageEnabled,
        public readonly ?float $billedQuantity,
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
            overageQuantity: $data["overageQuantity"] ?? null,
            overageUnitPrice: $data["overageUnitPrice"] ?? null,
            unlimited: $data["unlimited"] ?? null,
            overageEnabled: $data["overageEnabled"] ?? null,
            billedQuantity: $data["billedQuantity"] ?? null,
        );
    }
}
