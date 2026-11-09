<?php

declare(strict_types=1);

namespace Commet\Webhooks;

/** Fired when a subscription moves to another version of its plan: a move applied now or a scheduled move that took effect at renewal. Making an experiment current moves nobody, so it sends none. The plan stays the same; the version's prices and features apply from now on. */
final class SubscriptionVersionChangedData
{
    public function __construct(
        public readonly string $subscriptionId,
        public readonly string $customerId,
        public readonly string $fromVersionId,
        public readonly string $toVersionId,
        public readonly string $currency,
        public readonly string $billingInterval,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            subscriptionId: $data["subscriptionId"],
            customerId: $data["customerId"],
            fromVersionId: $data["fromVersionId"],
            toVersionId: $data["toVersionId"],
            currency: $data["currency"],
            billingInterval: $data["billingInterval"],
        );
    }
}
