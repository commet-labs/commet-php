<?php

declare(strict_types=1);

namespace Commet\Webhooks;

/** Fired when a subscription's prepaid balance crosses below 10% of its last refill (period reset, top-up, or manual adjustment). Emitted once per crossing. */
final class BalanceLowData
{
    public function __construct(
        public readonly string $subscriptionId,
        public readonly string $customerId,
        public readonly float $currentBalance,
        public readonly float $thresholdBalance,
        public readonly string $currency,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            subscriptionId: $data["subscriptionId"],
            customerId: $data["customerId"],
            currentBalance: $data["currentBalance"],
            thresholdBalance: $data["thresholdBalance"],
            currency: $data["currency"],
        );
    }
}
