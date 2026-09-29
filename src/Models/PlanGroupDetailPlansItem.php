<?php

declare(strict_types=1);

namespace Commet\Models;

class PlanGroupDetailPlansItem implements \JsonSerializable
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly int $sortOrder,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["id"] = $this->id;
        $values["name"] = $this->name;
        $values["sortOrder"] = $this->sortOrder;
        return (object) $values;
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data["id"],
            name: $data["name"],
            sortOrder: $data["sort_order"],
        );
    }
}
