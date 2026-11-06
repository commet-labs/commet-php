<?php

declare(strict_types=1);

namespace Commet\Models;

class PlanDraft implements \JsonSerializable
{
    public function __construct(
        public readonly string $id,
        public readonly string $fromVersionId,
        /** @var PlanDraftChangesItem[] */
        public readonly array $changes,
        public readonly string $createdAt,
        public readonly string $updatedAt,
        public readonly string $object,
        public readonly bool $livemode,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["id"] = $this->id;
        $values["fromVersionId"] = $this->fromVersionId;
        $values["changes"] = $this->changes;
        $values["createdAt"] = $this->createdAt;
        $values["updatedAt"] = $this->updatedAt;
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
            fromVersionId: $data["from_version_id"],
            changes: array_map(fn(array $item) => PlanDraftChangesItem::fromArray($item), $data["changes"]),
            createdAt: $data["created_at"],
            updatedAt: $data["updated_at"],
            object: $data["object"],
            livemode: $data["livemode"],
        );
    }
}
