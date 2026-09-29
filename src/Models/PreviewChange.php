<?php

declare(strict_types=1);

namespace Commet\Models;

class PreviewChange implements \JsonSerializable
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
        public readonly ?PreviewChangeOfferApplication $offerApplication = null,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["currency"] = $this->currency;
        $values["currentPlanCredit"] = $this->currentPlanCredit;
        $values["newPlanCharge"] = $this->newPlanCharge;
        $values["estimatedTotal"] = $this->estimatedTotal;
        $values["effectiveDate"] = $this->effectiveDate;
        $values["daysRemaining"] = $this->daysRemaining;
        $values["totalDays"] = $this->totalDays;
        $values["isUpgrade"] = $this->isUpgrade;
        if ($this->offerApplication !== null) {
            $values["offerApplication"] = $this->offerApplication;
        }
        $values["object"] = $this->object;
        $values["livemode"] = $this->livemode;
        return (object) $values;
    }

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
            offerApplication: isset($data["offer_application"]) ? PreviewChangeOfferApplication::fromArray($data["offer_application"]) : null,
        );
    }
}
