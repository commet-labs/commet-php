<?php

declare(strict_types=1);

namespace Commet\Webhooks;

use Commet\Models\WebhookPlanRef;

/** Fired when a scheduled plan change will no longer take effect: it was revoked through the API, the dashboard or the customer portal, an immediate plan change or an immediate cancellation voided it, or a different change replaced it. A replacement also fires subscription.plan_change_scheduled with the new target plan. */
final class SubscriptionPlanChangeRevokedData
{
    public function __construct(
        public readonly string $subscriptionId,
        public readonly string $customerId,
        public readonly string $status,
        public readonly WebhookPlanRef $currentPlan,
        public readonly WebhookPlanRef $revokedPlan,
        public readonly ?string $billingInterval,
        public readonly ?string $revokedBillingInterval,
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
            revokedPlan: WebhookPlanRef::fromArray($data["revokedPlan"]),
            billingInterval: $data["billingInterval"] ?? null,
            revokedBillingInterval: $data["revokedBillingInterval"] ?? null,
        );
    }
}
