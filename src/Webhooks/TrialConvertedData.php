<?php

declare(strict_types=1);

namespace Commet\Webhooks;

/** Fired when a trialing customer converts to a paid subscription before the trial ends — today this happens when they change plan during the trial, which charges the full new plan price immediately. Trials that simply run out fire trial.expired instead. */
final class TrialConvertedData
{
    public function __construct(
        public readonly string $subscriptionId,
        public readonly string $customerId,
        public readonly string $status,
        public readonly string $planId,
        public readonly string $planName,
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
        );
    }
}
