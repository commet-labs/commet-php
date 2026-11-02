<?php

declare(strict_types=1);

namespace Commet\Models;

abstract class UpdatePlanParamsUnusedPlanCredits
{
    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return match ($data["type"] ?? null) {
            "expire" => UpdatePlanParamsUnusedPlanCreditsVariant1::fromArray($data),
            "roll_over" => UpdatePlanParamsUnusedPlanCreditsVariant2::fromArray($data),
            default => UpdatePlanParamsUnusedPlanCreditsVariant1::fromArray($data),
        };
    }
}
