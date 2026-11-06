<?php

declare(strict_types=1);

namespace Commet\Models;

abstract class UpdatePlanParamsUnusedPlanBalance
{
    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return match ($data["type"] ?? null) {
            "expire" => UpdatePlanParamsUnusedPlanBalanceVariant1::fromArray($data),
            "roll_over" => UpdatePlanParamsUnusedPlanBalanceVariant2::fromArray($data),
            default => UpdatePlanParamsUnusedPlanBalanceVariant1::fromArray($data),
        };
    }
}
