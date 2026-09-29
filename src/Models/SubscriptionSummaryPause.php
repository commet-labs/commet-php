<?php

declare(strict_types=1);

namespace Commet\Models;

abstract class SubscriptionSummaryPause
{
    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return match ($data["status"] ?? null) {
            "scheduled" => SubscriptionSummaryPauseVariant1::fromArray($data),
            "active" => SubscriptionSummaryPauseVariant2::fromArray($data),
            default => SubscriptionSummaryPauseVariant1::fromArray($data),
        };
    }
}
