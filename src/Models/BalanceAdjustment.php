<?php

declare(strict_types=1);

namespace Commet\Models;

class BalanceAdjustment implements \JsonSerializable
{
    public function __construct(
        public readonly int $amount,
        public readonly int $newBalance,
        public readonly string $object,
        public readonly bool $livemode,
        public readonly ?string $reason = null,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["amount"] = $this->amount;
        $values["newBalance"] = $this->newBalance;
        $values["reason"] = $this->reason;
        $values["object"] = $this->object;
        $values["livemode"] = $this->livemode;
        return (object) $values;
    }

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
