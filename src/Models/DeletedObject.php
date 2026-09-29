<?php

declare(strict_types=1);

namespace Commet\Models;

class DeletedObject implements \JsonSerializable
{
    public function __construct(
        public readonly string $id,
        public readonly mixed $deleted,
        public readonly string $object,
        public readonly bool $livemode,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["id"] = $this->id;
        $values["deleted"] = $this->deleted;
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
            deleted: $data["deleted"],
            object: $data["object"],
            livemode: $data["livemode"],
        );
    }
}
