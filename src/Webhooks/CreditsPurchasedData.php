<?php

declare(strict_types=1);

namespace Commet\Webhooks;

/** Fired when a customer buys a credit pack through the customer portal and the payment succeeds. Purchased credits never expire — unlike plan credits, they survive period resets. Plan-included credit grants fire credits.granted instead. */
final class CreditsPurchasedData
{
    public function __construct(
        public readonly string $subscriptionId,
        public readonly string $customerId,
        public readonly string $invoiceId,
        public readonly string $invoiceNumber,
        public readonly string $creditPackName,
        public readonly float $credits,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            subscriptionId: $data["subscriptionId"],
            customerId: $data["customerId"],
            invoiceId: $data["invoiceId"],
            invoiceNumber: $data["invoiceNumber"],
            creditPackName: $data["creditPackName"],
            credits: $data["credits"],
        );
    }
}
