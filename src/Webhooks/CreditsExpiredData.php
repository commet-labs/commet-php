<?php

declare(strict_types=1);

namespace Commet\Webhooks;

/** Fired at the period reset when unused plan credits from the previous period are discarded. Plan credits expire at period end; purchased credits never expire and are not affected. */
final class CreditsExpiredData
{
    public function __construct(
        public readonly string $subscriptionId,
        public readonly string $customerId,
        public readonly float $expiredCredits,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            subscriptionId: $data["subscriptionId"],
            customerId: $data["customerId"],
            expiredCredits: $data["expiredCredits"],
        );
    }
}
