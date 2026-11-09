<?php

declare(strict_types=1);

namespace Commet\Models;

class PlanVersion implements \JsonSerializable
{
    public function __construct(
        public readonly string $id,
        public readonly string $label,
        public readonly bool $isCurrent,
        public readonly int $subscriptionCount,
        /** @var PlanVersionPricesItem[] */
        public readonly array $prices,
        public readonly string $createdAt,
        public readonly string $object,
        public readonly bool $livemode,
        public readonly ?int $number = null,
        public readonly ?PlanVersionExperiment $experiment = null,
        public readonly ?string $parentVersionId = null,
        public readonly ?int $maxPlanCredits = null,
        public readonly ?int $maxPlanBalance = null,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["id"] = $this->id;
        $values["label"] = $this->label;
        $values["number"] = $this->number;
        $values["experiment"] = $this->experiment;
        $values["isCurrent"] = $this->isCurrent;
        $values["parentVersionId"] = $this->parentVersionId;
        $values["subscriptionCount"] = $this->subscriptionCount;
        $values["maxPlanCredits"] = $this->maxPlanCredits;
        $values["maxPlanBalance"] = $this->maxPlanBalance;
        $values["prices"] = $this->prices;
        $values["createdAt"] = $this->createdAt;
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
            id: $data["id"],
            label: $data["label"],
            isCurrent: $data["is_current"],
            subscriptionCount: $data["subscription_count"],
            prices: array_map(fn(array $item) => PlanVersionPricesItem::fromArray($item), $data["prices"]),
            createdAt: $data["created_at"],
            object: $data["object"],
            livemode: $data["livemode"],
            number: $data["number"] ?? null,
            experiment: isset($data["experiment"]) ? PlanVersionExperiment::fromArray($data["experiment"]) : null,
            parentVersionId: $data["parent_version_id"] ?? null,
            maxPlanCredits: $data["max_plan_credits"] ?? null,
            maxPlanBalance: $data["max_plan_balance"] ?? null,
        );
    }
}
