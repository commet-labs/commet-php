<?php

declare(strict_types=1);

namespace Commet\Webhooks;

/** Fired when non-purchase balance is granted to a subscription: the plan balance at the start of each billing period, or a manual adjustment from the dashboard or the API, which goes to the purchased balance. Balance top-ups fire balance.topped_up instead. */
final class BalanceGrantedData
{
    public function __construct(
        public readonly string $subscriptionId,
        public readonly string $customerId,
        public readonly float $amount,
        public readonly string $currency,
        public readonly string $reason,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            subscriptionId: $data["subscriptionId"],
            customerId: $data["customerId"],
            amount: $data["amount"],
            currency: $data["currency"],
            reason: $data["reason"],
        );
    }
}
