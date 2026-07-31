<?php

declare(strict_types=1);

namespace Commet\Models;

class PlanChangeVariant1OfferApplicationPhasesItemVariant2 extends PlanChangeVariant1OfferApplicationPhasesItem
{
    public function __construct(
        public readonly string $type,
        public readonly int $percentage,
        public readonly ?int $durationCycles = null,
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
            percentage: $data["percentage"],
            durationCycles: $data["duration_cycles"] ?? null,
            startsAt: $data["starts_at"] ?? null,
            endsAt: $data["ends_at"] ?? null,
        );
    }
}
