<?php

declare(strict_types=1);

namespace Commet\Models;

class SeatBalance
{
    public function __construct(
        public readonly int $current,
        public readonly string $asOf,
        public readonly string $object,
        public readonly bool $livemode,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            current: $data["current"],
            asOf: $data["as_of"],
            object: $data["object"],
            livemode: $data["livemode"],
        );
    }
}
