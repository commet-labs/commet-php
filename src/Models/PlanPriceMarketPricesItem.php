<?php

declare(strict_types=1);

namespace Commet\Models;

class PlanPriceMarketPricesItem
{
    public function __construct(
        public readonly string $marketGroupId,
        public readonly string $currency,
        public readonly int $price,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            marketGroupId: $data["market_group_id"],
            currency: $data["currency"],
            price: $data["price"],
        );
    }
}
