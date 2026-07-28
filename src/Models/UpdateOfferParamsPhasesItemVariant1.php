<?php

declare(strict_types=1);

namespace Commet\Models;

class UpdateOfferParamsPhasesItemVariant1 extends UpdateOfferParamsPhasesItem
{
    public function __construct(
        public readonly string $type,
        public readonly int $durationDays,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            type: $data["type"],
            durationDays: $data["duration_days"],
        );
    }
}
