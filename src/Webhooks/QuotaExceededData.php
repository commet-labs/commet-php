<?php

declare(strict_types=1);

namespace Commet\Webhooks;

/** Fired when a metered feature passes its included quantity. With overage enabled it means overage billing began; with overage disabled it means the hard limit was hit and further usage is rejected (this case also fires customer.state_changed with trigger quota_exceeded). Emitted once per feature per billing period. */
final class QuotaExceededData
{
    public function __construct(
        public readonly string $subscriptionId,
        public readonly string $customerId,
        public readonly string $featureCode,
        public readonly float $currentUsage,
        public readonly float $includedAmount,
        public readonly bool $overageEnabled,
        public readonly string $periodStart,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            subscriptionId: $data["subscriptionId"],
            customerId: $data["customerId"],
            featureCode: $data["featureCode"],
            currentUsage: $data["currentUsage"],
            includedAmount: $data["includedAmount"],
            overageEnabled: $data["overageEnabled"],
            periodStart: $data["periodStart"],
        );
    }
}
