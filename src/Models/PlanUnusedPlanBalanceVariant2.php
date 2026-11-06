<?php

declare(strict_types=1);

namespace Commet\Models;

class PlanUnusedPlanBalanceVariant2 extends PlanUnusedPlanBalance implements \JsonSerializable
{
    public function __construct(
        public readonly string $type,
        public readonly ?int $maxPlanBalance = null,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["type"] = $this->type;
        $values["maxPlanBalance"] = $this->maxPlanBalance;
        return (object) $values;
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            type: $data["type"],
            maxPlanBalance: $data["max_plan_balance"] ?? null,
        );
    }
}
