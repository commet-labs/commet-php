<?php

declare(strict_types=1);

namespace Commet\Models;

abstract class PlanUnusedPlanCredits
{
    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return match ($data["type"] ?? null) {
            "expire" => PlanUnusedPlanCreditsVariant1::fromArray($data),
            "roll_over" => PlanUnusedPlanCreditsVariant2::fromArray($data),
            default => PlanUnusedPlanCreditsVariant1::fromArray($data),
        };
    }
}
