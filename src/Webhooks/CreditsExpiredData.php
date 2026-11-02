<?php

declare(strict_types=1);

namespace Commet\Webhooks;

/** Fired at a reset when unused plan credits are discarded. On a plan whose unused plan credits expire, every unused plan credit expires at each reset. On a plan that rolls them over, a reset keeps them, up to the plan's maxPlanCredits when it has one, and only the excess expires. A change to another credits plan applies the new plan's terms the same way. Purchased credits never expire and are not affected. */
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
