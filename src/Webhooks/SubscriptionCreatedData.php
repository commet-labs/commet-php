<?php

declare(strict_types=1);

namespace Commet\Webhooks;

/** Fired when a subscription record is created, usually with status pending_payment: the first charge has not been confirmed yet — do NOT grant access here; wait for subscription.activated. A trial whose price requires no payment method is created already trialing, together with trial.started. */
final class SubscriptionCreatedData
{
    public function __construct(
        public readonly string $subscriptionId,
        public readonly string $customerId,
        public readonly string $planId,
        public readonly string $planName,
        public readonly string $status,
        public readonly string $startDate,
        public readonly ?string $name,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            subscriptionId: $data["subscriptionId"],
            customerId: $data["customerId"],
            planId: $data["planId"],
            planName: $data["planName"],
            status: $data["status"],
            startDate: $data["startDate"],
            name: $data["name"] ?? null,
        );
    }
}
