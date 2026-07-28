<?php

declare(strict_types=1);

namespace Commet\Models;

class PlanRegionalPricingOverridesItem
{
    public function __construct(
        public readonly string $currency,
        public readonly int $price,
        public readonly ?int $includedBalance = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            currency: $data["currency"],
            price: $data["price"],
            includedBalance: $data["included_balance"] ?? null,
        );
    }
}
