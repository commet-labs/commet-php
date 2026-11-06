<?php

declare(strict_types=1);

namespace Commet\Models;

class BusinessTaxId implements \JsonSerializable
{
    public function __construct(
        public readonly string $country,
        public readonly string $type,
        public readonly string $value,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["country"] = $this->country;
        $values["type"] = $this->type;
        $values["value"] = $this->value;
        return (object) $values;
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            country: $data["country"],
            type: $data["type"],
            value: $data["value"],
        );
    }
}
