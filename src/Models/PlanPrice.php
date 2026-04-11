<?php

declare(strict_types=1);

namespace Commet\Models;

class PlanPrice
{
    public function __construct(
        public readonly string $billingInterval,
        public readonly int $price,
        public readonly bool $isDefault,
        public readonly int $trialDays,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            billingInterval: $data['billing_interval'],
            price: $data['price'],
            isDefault: $data['is_default'],
            trialDays: $data['trial_days'],
        );
    }
}
