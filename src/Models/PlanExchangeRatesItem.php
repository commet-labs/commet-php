<?php

declare(strict_types=1);

namespace Commet\Models;

class PlanExchangeRatesItem
{
    public function __construct(
        public readonly string $currency,
        public readonly float $exchangeRate,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            currency: $data["currency"],
            exchangeRate: $data["exchange_rate"],
        );
    }
}
