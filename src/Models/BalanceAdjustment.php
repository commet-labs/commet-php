<?php

declare(strict_types=1);

namespace Commet\Models;

class BalanceAdjustment
{
    public function __construct(
        public readonly int $amount,
        public readonly int $newBalance,
        public readonly string $object,
        public readonly bool $livemode,
        public readonly ?string $reason = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            amount: $data["amount"],
            newBalance: $data["new_balance"],
            object: $data["object"],
            livemode: $data["livemode"],
            reason: $data["reason"] ?? null,
        );
    }
}
