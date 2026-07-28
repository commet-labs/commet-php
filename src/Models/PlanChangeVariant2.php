<?php

declare(strict_types=1);

namespace Commet\Models;

class PlanChangeVariant2 extends PlanChange
{
    public function __construct(
        public readonly string $outcome,
        public readonly string $id,
        public readonly mixed $scheduled,
        public readonly string $scheduledFor,
        public readonly string $changeType,
        public readonly string $customerId,
        public readonly string $object,
        public readonly bool $livemode,
        public readonly ?string $newPlanId = null,
        public readonly ?string $newPlanName = null,
        public readonly ?string $newBillingInterval = null,
        public readonly ?PlanChangeVariant2SeatLimitWarning $seatLimitWarning = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            outcome: $data["outcome"],
            id: $data["id"],
            scheduled: $data["scheduled"],
            scheduledFor: $data["scheduled_for"],
            changeType: $data["change_type"],
            customerId: $data["customer_id"],
            object: $data["object"],
            livemode: $data["livemode"],
            newPlanId: $data["new_plan_id"] ?? null,
            newPlanName: $data["new_plan_name"] ?? null,
            newBillingInterval: $data["new_billing_interval"] ?? null,
            seatLimitWarning: isset($data["seat_limit_warning"]) ? PlanChangeVariant2SeatLimitWarning::fromArray($data["seat_limit_warning"]) : null,
        );
    }
}
