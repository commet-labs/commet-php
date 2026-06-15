<?php

declare(strict_types=1);

namespace Commet\Webhooks;

/** Predictive event fired once, 3 days before a trial ends. Use it to remind the customer that billing starts soon. Emitted by a daily scan with a deterministic idempotency key, so it never fires twice for the same trial end date. */
final class TrialWillEndData
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
