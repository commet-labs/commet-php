<?php

declare(strict_types=1);

namespace Commet\Models;

class PlanChangeVariant2SeatLimitWarning
{
    public function __construct(
        public readonly string $featureCode,
        public readonly string $featureName,
        public readonly int $currentSeats,
        public readonly int $included,
        public readonly string $newPlanName,
        public readonly string $effectiveDate,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            featureCode: $data["feature_code"],
            featureName: $data["feature_name"],
            currentSeats: $data["current_seats"],
            included: $data["included"],
            newPlanName: $data["new_plan_name"],
            effectiveDate: $data["effective_date"],
        );
    }
}
