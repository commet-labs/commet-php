<?php

declare(strict_types=1);

namespace Commet\Models;

class SetPlanRegionalPricingParamsPricesItem
{
    public function __construct(
        public readonly string $priceId,
        public readonly int $price,
        public readonly ?int $includedBalance = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            priceId: $data["price_id"],
            price: $data["price"],
            includedBalance: $data["included_balance"] ?? null,
        );
    }
}
