<?php

declare(strict_types=1);

namespace Commet\Models;

class SubscriptionDiscount
{
    public function __construct(
        public readonly string $type,
        public readonly float $value,
        public readonly ?string $name = null,
        public readonly ?string $endsAt = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            type: $data["type"],
            value: $data["value"],
            name: $data["name"] ?? null,
            endsAt: $data["ends_at"] ?? null,
        );
    }
}
