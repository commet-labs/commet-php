<?php

declare(strict_types=1);

namespace Commet\Models;

class PlanMove implements \JsonSerializable
{
    public function __construct(
        public readonly string $toVersionId,
        /** @var string[] */
        public readonly array $fromVersionIds,
        public readonly string $effective,
        public readonly bool $preview,
        public readonly string $status,
        public readonly PlanMoveCounts $counts,
        /** @var PlanMoveSubscriptionsItem[] */
        public readonly array $subscriptions,
        public readonly string $object,
        public readonly bool $livemode,
        public readonly ?string $id = null,
        public readonly ?string $createdAt = null,
        public readonly ?string $completedAt = null,
        public readonly ?string $canceledAt = null,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["id"] = $this->id;
        $values["toVersionId"] = $this->toVersionId;
        $values["fromVersionIds"] = $this->fromVersionIds;
        $values["effective"] = $this->effective;
        $values["preview"] = $this->preview;
        $values["status"] = $this->status;
        $values["counts"] = $this->counts;
        $values["subscriptions"] = $this->subscriptions;
        $values["createdAt"] = $this->createdAt;
        $values["completedAt"] = $this->completedAt;
        $values["canceledAt"] = $this->canceledAt;
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
            toVersionId: $data["to_version_id"],
            fromVersionIds: $data["from_version_ids"],
            effective: $data["effective"],
            preview: $data["preview"],
            status: $data["status"],
            counts: PlanMoveCounts::fromArray($data["counts"]),
            subscriptions: array_map(fn(array $item) => PlanMoveSubscriptionsItem::fromArray($item), $data["subscriptions"]),
            object: $data["object"],
            livemode: $data["livemode"],
            id: $data["id"] ?? null,
            createdAt: $data["created_at"] ?? null,
            completedAt: $data["completed_at"] ?? null,
            canceledAt: $data["canceled_at"] ?? null,
        );
    }
}
