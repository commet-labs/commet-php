<?php

declare(strict_types=1);

namespace Commet\Webhooks;

/** Fired at a reset when unused plan balance is discarded. On a plan whose unused plan balance expires, all of it expires at each reset. On a plan that rolls it over, a reset keeps it, up to the plan's maxPlanBalance when it has one, and only the excess expires. An overage debt invoiced at the renewal counts as nothing left over. Purchased balance never expires and is not affected. */
final class BalanceExpiredData
{
    public function __construct(
        public readonly string $subscriptionId,
        public readonly string $customerId,
        public readonly float $expiredAmount,
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
            expiredAmount: $data["expiredAmount"],
            currency: $data["currency"],
        );
    }
}
