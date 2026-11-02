<?php

declare(strict_types=1);

namespace Commet\Models;

abstract class CreatePlanParamsUnusedPlanCredits
{
    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return match ($data["type"] ?? null) {
            "expire" => CreatePlanParamsUnusedPlanCreditsVariant1::fromArray($data),
            "roll_over" => CreatePlanParamsUnusedPlanCreditsVariant2::fromArray($data),
            default => CreatePlanParamsUnusedPlanCreditsVariant1::fromArray($data),
        };
    }
}
