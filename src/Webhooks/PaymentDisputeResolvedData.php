<?php

declare(strict_types=1);

namespace Commet\Webhooks;

use Commet\Enums\PaymentProvider;

/** Fired when a dispute is closed. Carries the same identifiers as payment.disputed plus the outcome: won restores the frozen amount to your balance, lost keeps the chargeback deducted. */
final class PaymentDisputeResolvedData
{
    public function __construct(
        public readonly string $paymentTransactionId,
        public readonly PaymentProvider $provider,
        public readonly ?string $paymentLinkId,
        public readonly ?string $invoiceId,
        public readonly ?string $invoiceNumber,
        public readonly ?string $customerId,
        public readonly ?string $subscriptionId,
        public readonly float $disputeAmount,
        public readonly string $currency,
        public readonly ?string $disputeReason,
        public readonly string $outcome,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            paymentTransactionId: $data["paymentTransactionId"],
            provider: PaymentProvider::fromArray($data["provider"]),
            paymentLinkId: $data["paymentLinkId"] ?? null,
            invoiceId: $data["invoiceId"] ?? null,
            invoiceNumber: $data["invoiceNumber"] ?? null,
            customerId: $data["customerId"] ?? null,
            subscriptionId: $data["subscriptionId"] ?? null,
            disputeAmount: $data["disputeAmount"],
            currency: $data["currency"],
            disputeReason: $data["disputeReason"] ?? null,
            outcome: $data["outcome"],
        );
    }
}
