<?php

declare(strict_types=1);

namespace Commet\Models;

abstract class CreatePlanParamsUnusedPlanBalance
{
    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return match ($data["type"] ?? null) {
            "expire" => CreatePlanParamsUnusedPlanBalanceVariant1::fromArray($data),
            "roll_over" => CreatePlanParamsUnusedPlanBalanceVariant2::fromArray($data),
            default => CreatePlanParamsUnusedPlanBalanceVariant1::fromArray($data),
        };
    }
}
