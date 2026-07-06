<?php

declare(strict_types=1);

namespace Commet\Webhooks;

/** Fired when a recurring payment is successfully processed. This event is for recurring charges only — the first checkout payment triggers subscription.activated instead. */
final class PaymentReceivedData
{
    public function __construct(
        public readonly string $invoiceId,
        public readonly string $invoiceNumber,
        public readonly float $invoiceTotal,
        public readonly string $customerId,
        public readonly ?string $subscriptionId,
        public readonly ?string $paymentTransactionId,
        public readonly ?float $grossAmount,
        public readonly ?string $currency,
        public readonly ?float $orgNetAmount,
        public readonly ?string $customerEmail,
        public readonly string $paidAt,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            invoiceId: $data["invoiceId"],
            invoiceNumber: $data["invoiceNumber"],
            invoiceTotal: $data["invoiceTotal"],
            customerId: $data["customerId"],
            subscriptionId: $data["subscriptionId"] ?? null,
            paymentTransactionId: $data["paymentTransactionId"] ?? null,
            grossAmount: $data["grossAmount"] ?? null,
            currency: $data["currency"] ?? null,
            orgNetAmount: $data["orgNetAmount"] ?? null,
            customerEmail: $data["customerEmail"] ?? null,
            paidAt: $data["paidAt"],
        );
    }
}
