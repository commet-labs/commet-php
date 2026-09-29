<?php

declare(strict_types=1);

namespace Commet\Webhooks;

/** Fired when a payment is refunded, fully or partially. A refund does not change the subscription. Cancel it separately if it should end. */
final class PaymentRefundedData
{
    public function __construct(
        public readonly string $paymentTransactionId,
        public readonly string $provider,
        public readonly ?string $paymentLinkId,
        public readonly ?string $invoiceId,
        public readonly ?string $invoiceNumber,
        public readonly ?string $customerId,
        public readonly ?string $subscriptionId,
        public readonly float $refundAmount,
        public readonly string $currency,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            paymentTransactionId: $data["paymentTransactionId"],
            provider: $data["provider"],
            paymentLinkId: $data["paymentLinkId"] ?? null,
            invoiceId: $data["invoiceId"] ?? null,
            invoiceNumber: $data["invoiceNumber"] ?? null,
            customerId: $data["customerId"] ?? null,
            subscriptionId: $data["subscriptionId"] ?? null,
            refundAmount: $data["refundAmount"],
            currency: $data["currency"],
        );
    }
}
