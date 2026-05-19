<?php

declare(strict_types=1);

namespace Commet\Models;

use Commet\Enums\BillingInterval;

class PlanPrice
{
    public function __construct(
        public readonly BillingInterval $billingInterval,
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
            billingInterval: BillingInterval::from($data['billing_interval']),
            price: $data['price'],
            isDefault: $data['is_default'],
            trialDays: $data['trial_days'],
        );
    }
}
