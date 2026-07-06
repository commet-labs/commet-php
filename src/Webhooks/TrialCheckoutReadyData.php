<?php

declare(strict_types=1);

namespace Commet\Webhooks;

/** Fired when a trial checkout link is ready to share with the customer. Completing this checkout saves a payment method and starts the trial (trial.started) — the customer is not charged until the trial ends. */
final class TrialCheckoutReadyData
{
    public function __construct(
        public readonly string $subscriptionId,
        public readonly string $customerId,
        public readonly string $planName,
        public readonly float $trialDays,
        public readonly string $checkoutUrl,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            subscriptionId: $data["subscriptionId"],
            customerId: $data["customerId"],
            planName: $data["planName"],
            trialDays: $data["trialDays"],
            checkoutUrl: $data["checkoutUrl"],
        );
    }
}
