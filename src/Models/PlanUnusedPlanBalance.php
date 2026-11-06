<?php

declare(strict_types=1);

namespace Commet\Models;

abstract class PlanUnusedPlanBalance
{
    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return match ($data["type"] ?? null) {
            "expire" => PlanUnusedPlanBalanceVariant1::fromArray($data),
            "roll_over" => PlanUnusedPlanBalanceVariant2::fromArray($data),
            default => PlanUnusedPlanBalanceVariant1::fromArray($data),
        };
    }
}
