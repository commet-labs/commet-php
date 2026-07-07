<?php

declare(strict_types=1);

namespace Commet\Webhooks;

/** Fired when a metered feature's usage crosses 80% of its included quantity for the current period. Emitted once per feature per billing period, when the crossing happens. */
final class QuotaThresholdReachedData
{
    public function __construct(
        public readonly string $subscriptionId,
        public readonly string $customerId,
        public readonly string $featureCode,
        public readonly float $currentUsage,
        public readonly float $includedAmount,
        public readonly string $periodStart,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            subscriptionId: $data["subscriptionId"],
            customerId: $data["customerId"],
            featureCode: $data["featureCode"],
            currentUsage: $data["currentUsage"],
            includedAmount: $data["includedAmount"],
            periodStart: $data["periodStart"],
        );
    }
}
