<?php

declare(strict_types=1);

namespace Commet\Models;

class TrackUsageParamsPropertiesItem
{
    public function __construct(
        public readonly string $property,
        public readonly string $value,
    ) {}

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
