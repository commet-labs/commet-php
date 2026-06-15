<?php

declare(strict_types=1);

namespace Commet\Webhooks;

/** Fired when a scheduled cancellation is reverted before it executes. The subscription continues on its current plan and billing period as if it had never been canceled. */
final class SubscriptionCancellationRevokedData
{
    public function __construct(
        public readonly string $subscriptionId,
        public readonly string $customerId,
        public readonly string $status,
        public readonly ?string $currentPeriodEnd,
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
            currentPeriodEnd: $data["currentPeriodEnd"] ?? null,
        );
    }
}
