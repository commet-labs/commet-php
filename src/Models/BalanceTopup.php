<?php

declare(strict_types=1);

namespace Commet\Models;

class BalanceTopup
{
    public function __construct(
        public readonly int $amount,
        public readonly string $object,
        public readonly bool $livemode,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            amount: $data["amount"],
            object: $data["object"],
            livemode: $data["livemode"],
        );
    }
}
