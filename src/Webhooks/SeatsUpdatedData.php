<?php

declare(strict_types=1);

namespace Commet\Webhooks;

/** Fired when a customer's seat count changes for a seats-type feature — via the SDK seats endpoints or the dashboard. Also fires customer.state_changed with trigger seats_updated. */
final class SeatsUpdatedData
{
    public function __construct(
        public readonly string $customerId,
        public readonly ?string $subscriptionId,
        public readonly string $featureCode,
        public readonly float $previousSeats,
        public readonly float $currentSeats,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            customerId: $data["customerId"],
            subscriptionId: $data["subscriptionId"] ?? null,
            featureCode: $data["featureCode"],
            previousSeats: $data["previousSeats"],
            currentSeats: $data["currentSeats"],
        );
    }
}
