<?php

declare(strict_types=1);

namespace Commet\Models;

class PlanFeaturesItemRegionalPricesItem
{
    public function __construct(
        public readonly string $currency,
        public readonly bool $autoSynced,
        public readonly ?int $overageUnitPrice = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            currency: $data["currency"],
            autoSynced: $data["auto_synced"],
            overageUnitPrice: $data["overage_unit_price"] ?? null,
        );
    }
}
