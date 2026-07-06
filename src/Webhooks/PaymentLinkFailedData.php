<?php

declare(strict_types=1);

namespace Commet\Webhooks;

/** Fired when a payment link charge attempt is declined. The link stays open and can be paid again — a failed link is retryable. */
final class PaymentLinkFailedData
{
    public function __construct(
        public readonly string $paymentId,
        public readonly string $status,
        public readonly float $amount,
        public readonly string $currency,
        public readonly string $description,
        public readonly ?string $customerId,
        public readonly string $failureCode,
        public readonly string $failureMessage,
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
            failureCode: $data["failureCode"],
            failureMessage: $data["failureMessage"],
        );
    }
}
