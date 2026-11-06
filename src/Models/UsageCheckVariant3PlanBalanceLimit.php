<?php

declare(strict_types=1);

namespace Commet\Models;

class UsageCheckVariant3PlanBalanceLimit implements \JsonSerializable
{
    public function __construct(
        public readonly int $amount,
        public readonly string $interval,
        public readonly int $spent,
        public readonly int $remaining,
        public readonly string $resetsAt,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["amount"] = $this->amount;
        $values["interval"] = $this->interval;
        $values["spent"] = $this->spent;
        $values["remaining"] = $this->remaining;
        $values["resetsAt"] = $this->resetsAt;
        return (object) $values;
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            amount: $data["amount"],
            interval: $data["interval"],
            spent: $data["spent"],
            remaining: $data["remaining"],
            resetsAt: $data["resets_at"],
        );
    }
}
