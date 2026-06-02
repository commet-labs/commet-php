<?php

declare(strict_types=1);

namespace Commet\Models;

use Commet\Enums\FeatureType;

class Feature
{
    public function __construct(
        public readonly string $code,
        public readonly string $object,
        public readonly bool $livemode,
        public readonly string $name,
        public readonly FeatureType $type,
        public readonly bool $allowed,
        public readonly ?bool $enabled = null,
        public readonly ?int $current = null,
        public readonly ?int $included = null,
        public readonly ?int $remaining = null,
        public readonly ?int $overage = null,
        public readonly ?int $overageUnitPrice = null,
        public readonly ?int $billedQuantity = null,
        public readonly ?bool $unlimited = null,
        public readonly ?bool $overageEnabled = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            code: $data['code'],
            object: $data['object'] ?? 'feature',
            livemode: $data['livemode'] ?? false,
            name: $data['name'],
            type: FeatureType::from($data['type']),
            allowed: $data['allowed'],
            enabled: $data['enabled'] ?? null,
            current: $data['current'] ?? null,
            included: $data['included'] ?? null,
            remaining: $data['remaining'] ?? null,
            overage: $data['overage'] ?? null,
            overageUnitPrice: $data['overage_unit_price'] ?? null,
            billedQuantity: $data['billed_quantity'] ?? null,
            unlimited: $data['unlimited'] ?? null,
            overageEnabled: $data['overage_enabled'] ?? null,
        );
    }
}
