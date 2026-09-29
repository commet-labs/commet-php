<?php

declare(strict_types=1);

namespace Commet\Models;

class UsageEventPropertiesItem implements \JsonSerializable
{
    public function __construct(
        public readonly string $property,
        public readonly string $value,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["property"] = $this->property;
        $values["value"] = $this->value;
        return (object) $values;
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            property: $data["property"],
            value: $data["value"],
        );
    }
}
