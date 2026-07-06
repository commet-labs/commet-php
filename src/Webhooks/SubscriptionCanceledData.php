<?php

declare(strict_types=1);

namespace Commet\Webhooks;

/** Fired when a subscription is actually terminated at the end of the billing period. The status is now canceled and access should be revoked. This event is NOT fired when cancellation is scheduled — that triggers subscription.updated instead. See the cancellation lifecycle below. */
final class SubscriptionCanceledData
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
