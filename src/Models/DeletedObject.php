<?php

declare(strict_types=1);

namespace Commet\Models;

class DeletedObject
{
    public function __construct(
        public readonly string $id,
        public readonly mixed $deleted,
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
            deleted: $data["deleted"],
            object: $data["object"],
            livemode: $data["livemode"],
        );
    }
}
