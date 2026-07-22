<?php

declare(strict_types=1);

namespace Commet\Webhooks;

use Commet\Enums\PaymentProvider;

/** Fired when a payment is refunded, fully or partially. A full refund of a subscription invoice also cancels the subscription immediately (subscription.canceled fires with reason refund); partial refunds leave the subscription untouched. */
final class PaymentRefundedData
{
    public function __construct(
        public readonly string $paymentTransactionId,
        public readonly PaymentProvider $provider,
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
            provider: PaymentProvider::from($data["provider"]),
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
