<?php

declare(strict_types=1);

namespace Commet\Models;

class PlanDraftPublicationVersion implements \JsonSerializable
{
    public function __construct(
        public readonly string $id,
        public readonly string $label,
        public readonly bool $isCurrent,
        public readonly int $subscriptionCount,
        /** @var PlanDraftPublicationVersionPricesItem[] */
        public readonly array $prices,
        public readonly string $createdAt,
        public readonly ?int $number = null,
        public readonly ?PlanDraftPublicationVersionExperiment $experiment = null,
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
            prices: array_map(fn(array $item) => PlanDraftPublicationVersionPricesItem::fromArray($item), $data["prices"]),
            createdAt: $data["created_at"],
            number: $data["number"] ?? null,
            experiment: isset($data["experiment"]) ? PlanDraftPublicationVersionExperiment::fromArray($data["experiment"]) : null,
            parentVersionId: $data["parent_version_id"] ?? null,
            maxPlanCredits: $data["max_plan_credits"] ?? null,
            maxPlanBalance: $data["max_plan_balance"] ?? null,
        );
    }
}
