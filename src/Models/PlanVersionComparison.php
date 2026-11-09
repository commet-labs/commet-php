<?php

declare(strict_types=1);

namespace Commet\Models;

class PlanVersionComparison implements \JsonSerializable
{
    public function __construct(
        public readonly string $versionId,
        public readonly string $againstVersionId,
        /** @var PlanVersionComparisonChangesItem[] */
        public readonly array $changes,
        public readonly string $object,
        public readonly bool $livemode,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["versionId"] = $this->versionId;
        $values["againstVersionId"] = $this->againstVersionId;
        $values["changes"] = $this->changes;
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
            versionId: $data["version_id"],
            againstVersionId: $data["against_version_id"],
            changes: array_map(fn(array $item) => PlanVersionComparisonChangesItem::fromArray($item), $data["changes"]),
            object: $data["object"],
            livemode: $data["livemode"],
        );
    }
}
