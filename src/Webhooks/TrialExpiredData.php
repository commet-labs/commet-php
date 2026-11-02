<?php

declare(strict_types=1);

namespace Commet\Webhooks;

/** Fired when a trial period runs out. With a payment method the billing cycle activates the subscription and generates the first regular invoice right after — the natural trial-to-paid transition. A trial without a payment method instead moves to the plan group's default plan (subscription.plan_changed) or is canceled with cancelReason trial_ended_without_payment_method (subscription.canceled), without an invoice. */
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
