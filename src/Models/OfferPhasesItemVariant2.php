<?php

declare(strict_types=1);

namespace Commet\Models;

class OfferPhasesItemVariant2 extends OfferPhasesItem
{
    public function __construct(
        public readonly string $type,
        public readonly int $percentage,
        public readonly ?int $durationCycles = null,
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
        );
    }
}
