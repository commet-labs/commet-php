<?php

declare(strict_types=1);

namespace Commet\Models;

abstract class PlanChange
{
    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return match ($data["outcome"] ?? null) {
            "requires_checkout" => PlanChangeVariant1::fromArray($data),
            "scheduled" => PlanChangeVariant2::fromArray($data),
            "completed" => PlanChangeVariant3::fromArray($data),
            default => PlanChangeVariant1::fromArray($data),
        };
    }
}
