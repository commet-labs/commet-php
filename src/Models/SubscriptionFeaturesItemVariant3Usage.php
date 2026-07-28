<?php

declare(strict_types=1);

namespace Commet\Models;

class SubscriptionFeaturesItemVariant3Usage
{
    public function __construct(
        public readonly float $current,
        public readonly float $included,
        public readonly float $overageQuantity,
        public readonly ?float $overageUnitPrice = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            current: $data["current"],
            included: $data["included"],
            overageQuantity: $data["overage_quantity"],
            overageUnitPrice: $data["overage_unit_price"] ?? null,
        );
    }
}
