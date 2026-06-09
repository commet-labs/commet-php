<?php

declare(strict_types=1);

namespace Commet\Models;

class PlanVisibility
{
    public function __construct(
        public readonly string $id,
        public readonly bool $isPublic,
        public readonly string $object,
        public readonly bool $livemode,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data["id"],
            isPublic: $data["is_public"],
            object: $data["object"],
            livemode: $data["livemode"],
        );
    }
}
