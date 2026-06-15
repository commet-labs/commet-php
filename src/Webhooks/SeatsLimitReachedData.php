<?php

declare(strict_types=1);

namespace Commet\Webhooks;

/** Fired when a seat change reaches or passes the included seat limit of the customer's plan. Emitted once per crossing — only when the count moves from below the limit to at or above it. */
final class SeatsLimitReachedData
{
    public function __construct(
        public readonly string $customerId,
        public readonly string $subscriptionId,
        public readonly string $featureCode,
        public readonly float $currentSeats,
        public readonly float $includedSeats,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            customerId: $data["customerId"],
            subscriptionId: $data["subscriptionId"],
            featureCode: $data["featureCode"],
            currentSeats: $data["currentSeats"],
            includedSeats: $data["includedSeats"],
        );
    }
}
