<?php

declare(strict_types=1);

namespace Commet\Models;

class RemovedPlanFromGroup implements \JsonSerializable
{
    public function __construct(
        public readonly string $id,
        public readonly bool $removed,
        public readonly string $object,
        public readonly bool $livemode,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["id"] = $this->id;
        $values["removed"] = $this->removed;
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
            removed: $data["removed"],
            object: $data["object"],
            livemode: $data["livemode"],
        );
    }
}
