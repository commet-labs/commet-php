<?php

declare(strict_types=1);

namespace Commet\Models;

abstract class UsageCheck
{
    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return match ($data["consumption_model"] ?? null) {
            "metered" => UsageCheckVariant1::fromArray($data),
            "credits" => UsageCheckVariant2::fromArray($data),
            "balance" => UsageCheckVariant3::fromArray($data),
            default => UsageCheckVariant1::fromArray($data),
        };
    }
}
