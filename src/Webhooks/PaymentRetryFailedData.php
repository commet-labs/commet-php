<?php

declare(strict_types=1);

namespace Commet\Webhooks;

/** Fired when all dunning retries are exhausted and the subscription is canceled. This is the terminal event of the dunning flow — payment.recovered will not follow. Revoke access when you receive this. */
final class PaymentRetryFailedData
{
    public function __construct(
        public readonly string $invoiceId,
        public readonly string $invoiceNumber,
        public readonly string $customerId,
        public readonly string $subscriptionId,
        public readonly string $reason,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            invoiceId: $data["invoiceId"],
            invoiceNumber: $data["invoiceNumber"],
            customerId: $data["customerId"],
            subscriptionId: $data["subscriptionId"],
            reason: $data["reason"],
        );
    }
}
