<?php

declare(strict_types=1);

namespace Commet\Models;

class PreviewChangeOfferApplicationPhasesItemVariant2 extends PreviewChangeOfferApplicationPhasesItem
{
    public function __construct(
        public readonly string $type,
        public readonly int $durationCycles,
        public readonly int $amount,
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
            amount: $data["amount"],
            startsAt: $data["starts_at"] ?? null,
            endsAt: $data["ends_at"] ?? null,
        );
    }
}
