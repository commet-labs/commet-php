<?php

declare(strict_types=1);

namespace Commet\Webhooks;

/** Fired when a subscription record is created with status pending_payment. The first charge has not been confirmed yet — do NOT grant access here. Wait for subscription.activated. */
final class SubscriptionCreatedData
{
    public function __construct(
        public readonly string $subscriptionId,
        public readonly string $customerId,
        public readonly string $planId,
        public readonly string $planName,
        public readonly string $status,
        public readonly ?string $startDate,
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
            startDate: $data["startDate"] ?? null,
            name: $data["name"] ?? null,
        );
    }
}
