<?php

declare(strict_types=1);

namespace Commet\Models;

class CreatedSubscriptionScheduledPlanChange
{
    public function __construct(
        public readonly string $changeType,
        public readonly string $scheduledFor,
        public readonly ?string $newPlanId = null,
        public readonly ?string $newPlanName = null,
        public readonly ?string $newBillingInterval = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            changeType: $data["change_type"],
            scheduledFor: $data["scheduled_for"],
            newPlanId: $data["new_plan_id"] ?? null,
            newPlanName: $data["new_plan_name"] ?? null,
            newBillingInterval: $data["new_billing_interval"] ?? null,
        );
    }
}
