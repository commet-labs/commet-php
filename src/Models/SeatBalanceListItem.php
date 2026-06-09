<?php

declare(strict_types=1);

namespace Commet\Models;

class SeatBalanceListItem
{
    public function __construct(
        public readonly string $object,
        public readonly bool $livemode,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            object: $data["object"],
            livemode: $data["livemode"],
        );
    }
}
