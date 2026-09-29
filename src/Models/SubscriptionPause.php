<?php

declare(strict_types=1);

namespace Commet\Models;

abstract class SubscriptionPause
{
    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return match ($data["status"] ?? null) {
            "scheduled" => SubscriptionPauseVariant1::fromArray($data),
            "active" => SubscriptionPauseVariant2::fromArray($data),
            default => SubscriptionPauseVariant1::fromArray($data),
        };
    }
}
