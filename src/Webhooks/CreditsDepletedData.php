<?php

declare(strict_types=1);

namespace Commet\Webhooks;

/** Fired each time a subscription's available credits cross to zero or below. Usage that needs more credits than remain is rejected from this point, unless the plan allows overage, which is billed at its price per credit at the next renewal. Also fires customer.state_changed with trigger credits_depleted. */
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
