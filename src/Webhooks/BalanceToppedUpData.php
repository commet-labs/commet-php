<?php

declare(strict_types=1);

namespace Commet\Webhooks;

/** Fired when a balance top-up succeeds: through the API, an automatic top-up or the customer portal. The amount goes to the purchased balance, which is spent after the plan balance and kept until the subscription ends. */
final class BalanceToppedUpData
{
    public function __construct(
        public readonly string $subscriptionId,
        public readonly string $customerId,
        public readonly string $invoiceId,
        public readonly string $invoiceNumber,
        public readonly float $amount,
        public readonly string $currency,
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
            amount: $data["amount"],
            currency: $data["currency"],
        );
    }
}
