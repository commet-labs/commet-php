<?php

declare(strict_types=1);

namespace Commet\Models;

class CreateOfferParamsPhasesItemVariant2 extends CreateOfferParamsPhasesItem
{
    public function __construct(
        public readonly string $type,
        public readonly int $durationCycles,
        public readonly int $percentage,
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
        );
    }
}
