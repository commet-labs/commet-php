<?php

declare(strict_types=1);

namespace Commet\Webhooks;

use Commet\Models\WebhookPlanRef;

/** Fired when a subscription changes from one plan to another, including upgrades, downgrades, and billing interval changes. Access does not change on this event — the subscription stays active. */
final class SubscriptionPlanChangedData
{
    public function __construct(
        public readonly string $subscriptionId,
        public readonly string $customerId,
        public readonly WebhookPlanRef $previousPlan,
        public readonly WebhookPlanRef $currentPlan,
        public readonly ?string $billingInterval,
        public readonly float $credit,
        public readonly float $charge,
        public readonly float $totalCharged,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            subscriptionId: $data["subscriptionId"],
            customerId: $data["customerId"],
            previousPlan: WebhookPlanRef::fromArray($data["previousPlan"]),
            currentPlan: WebhookPlanRef::fromArray($data["currentPlan"]),
            billingInterval: $data["billingInterval"] ?? null,
            credit: $data["credit"],
            charge: $data["charge"],
            totalCharged: $data["totalCharged"],
        );
    }
}
