<?php

declare(strict_types=1);

namespace Commet\Webhooks;

/** Fired when a plan change (downgrade or shorter interval) is scheduled for the end of the billing period. The subscription stays on the current plan until effectiveAt, when subscription.plan_changed fires. */
final class SubscriptionPlanChangeScheduledData
{
    public function __construct(
        public readonly string $subscriptionId,
        public readonly string $customerId,
        public readonly string $status,
        public readonly WebhookPlanRef $currentPlan,
        public readonly WebhookPlanRef $scheduledPlan,
        public readonly ?string $billingInterval,
        public readonly ?string $scheduledBillingInterval,
        public readonly string $effectiveAt,
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
            currentPlan: WebhookPlanRef::fromArray($data["currentPlan"]),
            scheduledPlan: WebhookPlanRef::fromArray($data["scheduledPlan"]),
            billingInterval: $data["billingInterval"] ?? null,
            scheduledBillingInterval: $data["scheduledBillingInterval"] ?? null,
            effectiveAt: $data["effectiveAt"],
        );
    }
}
