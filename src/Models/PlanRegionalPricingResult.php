<?php

declare(strict_types=1);

namespace Commet\Models;

class PlanRegionalPricingResult
{
    public function __construct(
        public readonly string $planId,
        public readonly string $currency,
        public readonly float $exchangeRate,
        public readonly int $pricesConfigured,
        public readonly int $featuresConfigured,
        public readonly string $object,
        public readonly bool $livemode,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            planId: $data["plan_id"],
            currency: $data["currency"],
            exchangeRate: $data["exchange_rate"],
            pricesConfigured: $data["prices_configured"],
            featuresConfigured: $data["features_configured"],
            object: $data["object"],
            livemode: $data["livemode"],
        );
    }
}
