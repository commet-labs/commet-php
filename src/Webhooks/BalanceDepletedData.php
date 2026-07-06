<?php

declare(strict_types=1);

namespace Commet\Webhooks;

/** Fired when a subscription's prepaid balance crosses to zero or below. With block-on-exhaustion plans further usage is rejected; otherwise the balance can go negative. Also fires customer.state_changed with trigger balance_depleted. */
final class BalanceDepletedData
{
    public function __construct(
        public readonly string $subscriptionId,
        public readonly string $customerId,
        public readonly float $currentBalance,
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
            currentBalance: $data["currentBalance"],
            currency: $data["currency"],
        );
    }
}
