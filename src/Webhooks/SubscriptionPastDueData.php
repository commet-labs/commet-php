<?php

declare(strict_types=1);

namespace Commet\Webhooks;

/** Fired when a recurring payment fails on a previously paid subscription and its status becomes past_due. past_due is a grace window, not a cutoff: usage and seats keep working while new purchases are blocked, and dunning retries the charge — use this to notify the customer and recover the payment. */
final class SubscriptionPastDueData
{
    public function __construct(
        public readonly string $subscriptionId,
        public readonly string $customerId,
        public readonly string $status,
        public readonly string $invoiceId,
        public readonly string $invoiceNumber,
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
            invoiceNumber: $data["invoiceNumber"],
        );
    }
}
