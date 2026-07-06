<?php

declare(strict_types=1);

namespace Commet\Webhooks;

/** Fired when a trial period runs out and the billing cycle activates the subscription. The first regular invoice is generated right after — this is the natural trial-to-paid transition. */
final class TrialExpiredData
{
    public function __construct(
        public readonly string $subscriptionId,
        public readonly string $customerId,
        public readonly string $status,
        public readonly string $planId,
        public readonly string $planName,
        public readonly string $trialEndsAt,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            subscriptionId: $data["subscriptionId"],
            customerId: $data["customerId"],
            status: $data["status"],
            planId: $data["planId"],
            planName: $data["planName"],
            trialEndsAt: $data["trialEndsAt"],
        );
    }
}
