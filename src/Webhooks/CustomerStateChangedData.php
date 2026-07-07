<?php

declare(strict_types=1);

namespace Commet\Webhooks;

use Commet\Models\WebhookBalance;
use Commet\Models\WebhookCreditsBalance;
use Commet\Models\WebhookFeatureAccess;
use Commet\Models\WebhookPlanRef;
use Commet\Models\WebhookSeatSummary;

/** Aggregate entitlement event answering one question: what can this customer access right now? Fired on every entitlement transition (subscription lifecycle, plan changes, trials, past due, scheduled cancellations) with the customer's CURRENT subscription, plan, features, seats, and credits or balance. Handle this single event to keep access in sync instead of wiring every lifecycle event. */
final class CustomerStateChangedData
{
    public function __construct(
        public readonly string $customerId,
        public readonly string $trigger,
        public readonly string $status,
        public readonly ?string $subscriptionId,
        public readonly ?WebhookPlanRef $plan,
        public readonly ?string $billingInterval,
        public readonly ?string $consumptionModel,
        /** @var WebhookFeatureAccess[] */
        public readonly array $features,
        /** @var WebhookSeatSummary[] */
        public readonly array $seats,
        public readonly ?WebhookCreditsBalance $credits,
        public readonly ?WebhookBalance $balance,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            customerId: $data["customerId"],
            trigger: $data["trigger"],
            status: $data["status"],
            subscriptionId: $data["subscriptionId"] ?? null,
            plan: isset($data["plan"]) ? WebhookPlanRef::fromArray($data["plan"]) : null,
            billingInterval: $data["billingInterval"] ?? null,
            consumptionModel: $data["consumptionModel"] ?? null,
            features: array_map(fn(array $item) => WebhookFeatureAccess::fromArray($item), $data["features"] ?? []),
            seats: array_map(fn(array $item) => WebhookSeatSummary::fromArray($item), $data["seats"] ?? []),
            credits: isset($data["credits"]) ? WebhookCreditsBalance::fromArray($data["credits"]) : null,
            balance: isset($data["balance"]) ? WebhookBalance::fromArray($data["balance"]) : null,
        );
    }
}
