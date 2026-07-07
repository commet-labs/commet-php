<?php

declare(strict_types=1);

namespace Commet\Webhooks;

/** Fired when a subscription's credits hit zero. Usage requests that need more credits than remain are rejected from this point. Also fires customer.state_changed with trigger credits_depleted. */
final class CreditsDepletedData
{
    public function __construct(
        public readonly string $subscriptionId,
        public readonly string $customerId,
        public readonly float $remainingCredits,
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
        );
    }
}
