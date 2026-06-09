<?php

declare(strict_types=1);

namespace Commet\Models;

class RemovedPlanFeature
{
    public function __construct(
        public readonly string $id,
        public readonly mixed $removed,
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
            removed: $data["removed"],
            object: $data["object"],
            livemode: $data["livemode"],
        );
    }
}
