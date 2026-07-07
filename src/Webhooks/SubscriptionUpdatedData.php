<?php

declare(strict_types=1);

namespace Commet\Webhooks;

/** Fired when subscription details change. The most common trigger is scheduling a cancellation — when a customer cancels, the status stays "active" until the billing period ends, but canceledAt and endDate are set immediately. Use this event to show "your subscription will end on {endDate}" in your UI. Access should NOT be revoked here — wait for subscription.canceled. */
final class SubscriptionUpdatedData
{
    public function __construct(
        public readonly string $subscriptionId,
        public readonly string $customerId,
        public readonly string $status,
        public readonly string $canceledAt,
        public readonly ?string $cancelReason,
        public readonly string $endDate,
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
            canceledAt: $data["canceledAt"],
            cancelReason: $data["cancelReason"] ?? null,
            endDate: $data["endDate"],
        );
    }
}
