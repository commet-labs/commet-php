<?php

declare(strict_types=1);

namespace Commet\Models;

class UsageEventProperty
{
    public function __construct(
        public readonly string $id,
        public readonly string $usageEventId,
        public readonly string $property,
        public readonly string $value,
        public readonly string $createdAt,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            usageEventId: $data['usage_event_id'],
            property: $data['property'],
            value: $data['value'],
            createdAt: $data['created_at'],
        );
    }
}
