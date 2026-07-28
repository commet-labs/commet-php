<?php

declare(strict_types=1);

namespace Commet\Models;

class PlanRegionalPricing
{
    public function __construct(
        public readonly string $priceId,
        /** @var PlanRegionalPricingOverridesItem[] */
        public readonly array $overrides,
        public readonly string $object,
        public readonly bool $livemode,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            priceId: $data["price_id"],
            overrides: array_map(fn(array $item) => PlanRegionalPricingOverridesItem::fromArray($item), $data["overrides"]),
            object: $data["object"],
            livemode: $data["livemode"],
        );
    }
}
