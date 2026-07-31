<?php

declare(strict_types=1);

namespace Commet\Models;

class SubscriptionOfferApplicationPhaseVariant1 extends SubscriptionOfferApplicationPhase
{
    public function __construct(
        public readonly string $type,
        public readonly int $durationDays,
        public readonly ?string $startsAt = null,
        public readonly ?string $endsAt = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            type: $data["type"],
            durationDays: $data["duration_days"],
            startsAt: $data["starts_at"] ?? null,
            endsAt: $data["ends_at"] ?? null,
        );
    }
}
