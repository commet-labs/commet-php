<?php

declare(strict_types=1);

namespace Commet\Webhooks;

/** Predictive event fired once, 3 days before an active subscription renews. Use it to notify the customer before they are charged. Carries no amount — usage-based charges are only final at renewal, when invoice.created delivers the actual invoice. */
final class InvoiceUpcomingData
{
    public function __construct(
        public readonly string $subscriptionId,
        public readonly string $customerId,
        public readonly string $status,
        public readonly string $planId,
        public readonly string $planName,
        public readonly ?string $billingInterval,
        public readonly string $currentPeriodEnd,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            subscriptionId: $data["subscriptionId"],
            customerId: $data["customerId"],
            status: $data["status"],
            planId: $data["planId"],
            planName: $data["planName"],
            billingInterval: $data["billingInterval"] ?? null,
            currentPeriodEnd: $data["currentPeriodEnd"],
        );
    }
}
