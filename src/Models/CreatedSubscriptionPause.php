<?php

declare(strict_types=1);

namespace Commet\Models;

abstract class CreatedSubscriptionPause
{
    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return match ($data["status"] ?? null) {
            "scheduled" => CreatedSubscriptionPauseVariant1::fromArray($data),
            "active" => CreatedSubscriptionPauseVariant2::fromArray($data),
            default => CreatedSubscriptionPauseVariant1::fromArray($data),
        };
    }
}
