<?php

declare(strict_types=1);

namespace Commet\Webhooks;

/** Fired when a pending payment link is canceled before being paid. A canceled link can no longer be paid. */
final class PaymentLinkCanceledData
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
