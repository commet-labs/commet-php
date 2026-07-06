<?php

declare(strict_types=1);

namespace Commet\Webhooks;

/** Fired when a cardholder opens a dispute (chargeback) against a payment. The disputed amount is frozen from your payout balance while the dispute is open; Commet, as the Merchant of Record, handles the resolution process. payment.dispute_resolved fires with the outcome. */
final class PaymentDisputedData
{
    public function __construct(
        public readonly string $paymentTransactionId,
        public readonly ?string $paymentLinkId,
        public readonly ?string $invoiceId,
        public readonly ?string $invoiceNumber,
        public readonly ?string $customerId,
        public readonly ?string $subscriptionId,
        public readonly float $disputeAmount,
        public readonly string $currency,
        public readonly ?string $disputeReason,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            paymentTransactionId: $data["paymentTransactionId"],
            paymentLinkId: $data["paymentLinkId"] ?? null,
            invoiceId: $data["invoiceId"] ?? null,
            invoiceNumber: $data["invoiceNumber"] ?? null,
            customerId: $data["customerId"] ?? null,
            subscriptionId: $data["subscriptionId"] ?? null,
            disputeAmount: $data["disputeAmount"],
            currency: $data["currency"],
            disputeReason: $data["disputeReason"] ?? null,
        );
    }
}
