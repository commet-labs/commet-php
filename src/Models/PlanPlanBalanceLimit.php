<?php

declare(strict_types=1);

namespace Commet\Models;

class PlanPlanBalanceLimit implements \JsonSerializable
{
    public function __construct(
        public readonly int $amount,
        public readonly string $interval,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["amount"] = $this->amount;
        $values["interval"] = $this->interval;
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
        );
    }
}
