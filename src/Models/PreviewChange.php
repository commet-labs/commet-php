<?php

declare(strict_types=1);

namespace Commet\Models;

class PreviewChange
{
    public function __construct(
        public readonly string $currency,
        public readonly int $currentPlanCredit,
        public readonly int $newPlanCharge,
        public readonly int $estimatedTotal,
        public readonly string $effectiveDate,
        public readonly int $daysRemaining,
        public readonly int $totalDays,
        public readonly bool $isUpgrade,
        public readonly string $object,
        public readonly bool $livemode,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            currency: $data["currency"],
            currentPlanCredit: $data["current_plan_credit"],
            newPlanCharge: $data["new_plan_charge"],
            estimatedTotal: $data["estimated_total"],
            effectiveDate: $data["effective_date"],
            daysRemaining: $data["days_remaining"],
            totalDays: $data["total_days"],
            isUpgrade: $data["is_upgrade"],
            object: $data["object"],
            livemode: $data["livemode"],
        );
    }
}
