<?php

declare(strict_types=1);

namespace Commet\Models;

class PlanChangeVariant3PreviousPlan implements \JsonSerializable
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["id"] = $this->id;
        $values["name"] = $this->name;
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
        );
    }
}
