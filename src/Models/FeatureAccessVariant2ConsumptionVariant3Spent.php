<?php

declare(strict_types=1);

namespace Commet\Models;

class FeatureAccessVariant2ConsumptionVariant3Spent
{
    public function __construct(
        public readonly int $amount,
        public readonly string $currency,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            amount: $data["amount"],
            currency: $data["currency"],
        );
    }
}
