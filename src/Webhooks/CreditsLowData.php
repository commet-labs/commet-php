<?php

declare(strict_types=1);

namespace Commet\Webhooks;

/** Fired when a subscription's remaining credits cross below 10% of the credits granted for the current period. Emitted once per billing period, when the crossing happens. */
final class CreditsLowData
{
    public function __construct(
        public readonly string $subscriptionId,
        public readonly string $customerId,
        public readonly float $remainingCredits,
        public readonly float $thresholdCredits,
        public readonly float $periodCredits,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            subscriptionId: $data["subscriptionId"],
            customerId: $data["customerId"],
            remainingCredits: $data["remainingCredits"],
            thresholdCredits: $data["thresholdCredits"],
            periodCredits: $data["periodCredits"],
        );
    }
}
