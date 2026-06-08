<?php

declare(strict_types=1);

namespace Commet\Models;

class ReorderedPlans
{
    public function __construct(
        public readonly bool $reordered,
        public readonly string $object,
        public readonly bool $livemode,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            reordered: $data["reordered"],
            object: $data["object"],
            livemode: $data["livemode"],
        );
    }
}
