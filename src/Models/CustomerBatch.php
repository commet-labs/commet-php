<?php

declare(strict_types=1);

namespace Commet\Models;

class CustomerBatch
{
    public function __construct(
        /** @var list<array<string, mixed>> */
        public readonly array $successful,
        /** @var list<array<string, mixed>> */
        public readonly array $failed,
        public readonly string $object,
        public readonly bool $livemode,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            successful: $data["successful"] ?? [],
            failed: $data["failed"] ?? [],
            object: $data["object"],
            livemode: $data["livemode"],
        );
    }
}
