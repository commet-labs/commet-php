<?php

declare(strict_types=1);

namespace Commet\Webhooks;

/** Fired when a payment link is paid. The charge settled and a one-time invoice was generated. Fulfill the purchase on this event. */
final class PaymentLinkCompletedData
{
    public function __construct(
        public readonly string $paymentId,
        public readonly string $status,
        public readonly float $amount,
        public readonly string $currency,
        public readonly string $description,
        public readonly ?string $customerId,
        public readonly string $invoiceId,
        public readonly string $invoiceNumber,
        public readonly ?string $paymentTransactionId,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            paymentId: $data["paymentId"],
            status: $data["status"],
            amount: $data["amount"],
            currency: $data["currency"],
            description: $data["description"],
            customerId: $data["customerId"] ?? null,
            invoiceId: $data["invoiceId"],
            invoiceNumber: $data["invoiceNumber"],
            paymentTransactionId: $data["paymentTransactionId"] ?? null,
        );
    }
}
