<?php

declare(strict_types=1);

namespace Commet\Models;

class FeatureAccessVariant2ConsumptionVariant1Period
{
    public function __construct(
        public readonly string $start,
        public readonly string $end,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            start: $data["start"],
            end: $data["end"],
        );
    }
}
