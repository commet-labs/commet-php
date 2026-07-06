<?php

declare(strict_types=1);

namespace Commet\Webhooks;

/** Fired when a payment link is created. The link is pending — the customer has not paid yet. Do NOT fulfill here; wait for payment_link.completed. */
final class PaymentLinkCreatedData
{
    public function __construct(
        public readonly string $paymentId,
        public readonly string $status,
        public readonly float $amount,
        public readonly string $currency,
        public readonly string $description,
        public readonly ?string $customerId,
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
        );
    }
}
