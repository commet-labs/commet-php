<?php

declare(strict_types=1);

namespace Commet\Models;

class PlanRegionalPricingResult implements \JsonSerializable
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

    public function jsonSerialize(): object
    {
        $values = [];
        $values["planId"] = $this->planId;
        $values["currency"] = $this->currency;
        $values["exchangeRate"] = $this->exchangeRate;
        $values["pricesConfigured"] = $this->pricesConfigured;
        $values["featuresConfigured"] = $this->featuresConfigured;
        $values["object"] = $this->object;
        $values["livemode"] = $this->livemode;
        return (object) $values;
    }

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
