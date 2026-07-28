<?php

declare(strict_types=1);

namespace Commet\Models;

class SubscriptionCurrentPeriod
{
    public function __construct(
        public readonly string $start,
        public readonly string $end,
        public readonly float $daysRemaining,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            start: $data["start"],
            end: $data["end"],
            daysRemaining: $data["days_remaining"],
        );
    }
}
