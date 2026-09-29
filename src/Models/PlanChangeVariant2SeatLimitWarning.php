<?php

declare(strict_types=1);

namespace Commet\Models;

class PlanChangeVariant2SeatLimitWarning implements \JsonSerializable
{
    public function __construct(
        public readonly string $featureCode,
        public readonly string $featureName,
        public readonly int $currentSeats,
        public readonly int $included,
        public readonly string $newPlanName,
        public readonly string $effectiveDate,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["featureCode"] = $this->featureCode;
        $values["featureName"] = $this->featureName;
        $values["currentSeats"] = $this->currentSeats;
        $values["included"] = $this->included;
        $values["newPlanName"] = $this->newPlanName;
        $values["effectiveDate"] = $this->effectiveDate;
        return (object) $values;
    }

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
