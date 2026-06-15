<?php

declare(strict_types=1);

namespace Commet\Webhooks;

/** Fired when a cancellation is scheduled for the end of the billing period. The subscription stays active until effectiveAt — do NOT revoke access here. subscription.updated also fires for backward compatibility. */
final class SubscriptionCancellationScheduledData
{
    public function __construct(
        public readonly string $subscriptionId,
        public readonly string $customerId,
        public readonly string $status,
        public readonly string $canceledAt,
        public readonly ?string $cancelReason,
        public readonly string $effectiveAt,
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
            effectiveAt: $data["effectiveAt"],
        );
    }
}
