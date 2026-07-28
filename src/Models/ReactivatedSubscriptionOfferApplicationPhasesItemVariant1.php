<?php

declare(strict_types=1);

namespace Commet\Models;

class ReactivatedSubscriptionOfferApplicationPhasesItemVariant1 extends ReactivatedSubscriptionOfferApplicationPhasesItem
{
    public function __construct(
        public readonly string $type,
        public readonly int $durationCycles,
        public readonly int $percentage,
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
            durationCycles: $data["duration_cycles"],
            percentage: $data["percentage"],
            startsAt: $data["starts_at"] ?? null,
            endsAt: $data["ends_at"] ?? null,
        );
    }
}
