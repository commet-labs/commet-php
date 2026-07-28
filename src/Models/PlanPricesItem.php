<?php

declare(strict_types=1);

namespace Commet\Models;

use Commet\Enums\BillingInterval;

class PlanPricesItem
{
    public function __construct(
        public readonly string $id,
        public readonly BillingInterval $billingInterval,
        public readonly int $price,
        public readonly bool $isDefault,
        public readonly int $trialDays,
        /** @var array<string, mixed> */
        public readonly array $metadata,
        /** @var PlanPricesItemMarketPricesItem[] */
        public readonly array $marketPrices,
        /** @var PlanPricesItemRegionalPricesItem[] */
        public readonly array $regionalPrices,
        public readonly ?int $includedBalance = null,
        public readonly ?int $includedCredits = null,
        public readonly ?string $offerId = null,
        public readonly ?string $inheritsFromPriceId = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data["id"],
            billingInterval: BillingInterval::from($data["billing_interval"]),
            price: $data["price"],
            isDefault: $data["is_default"],
            trialDays: $data["trial_days"],
            metadata: $data["metadata"],
            marketPrices: array_map(fn(array $item) => PlanPricesItemMarketPricesItem::fromArray($item), $data["market_prices"]),
            regionalPrices: array_map(fn(array $item) => PlanPricesItemRegionalPricesItem::fromArray($item), $data["regional_prices"]),
            includedBalance: $data["included_balance"] ?? null,
            includedCredits: $data["included_credits"] ?? null,
            offerId: $data["offer_id"] ?? null,
            inheritsFromPriceId: $data["inherits_from_price_id"] ?? null,
        );
    }
}
