<?php

declare(strict_types=1);

namespace Commet\Models;

class PreviewChangeOfferApplicationPhasesItemVariant3 extends PreviewChangeOfferApplicationPhasesItem
{
    public function __construct(
        public readonly string $type,
        public readonly int $durationCycles,
        public readonly int $price,
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
            price: $data["price"],
            startsAt: $data["starts_at"] ?? null,
            endsAt: $data["ends_at"] ?? null,
        );
    }
}
