<?php

declare(strict_types=1);

namespace Commet\Webhooks;

/** Fired when a period-end resume charge fails. The subscription remains paused. */
final class SubscriptionResumeFailedData
{
    public function __construct(
        public readonly string $subscriptionId,
        public readonly string $customerId,
        public readonly string $status,
        public readonly string $invoiceId,
        public readonly string $failedAt,
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
            invoiceId: $data["invoiceId"],
            failedAt: $data["failedAt"],
        );
    }
}
