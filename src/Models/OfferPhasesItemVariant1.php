<?php

declare(strict_types=1);

namespace Commet\Models;

class OfferPhasesItemVariant1 extends OfferPhasesItem implements \JsonSerializable
{
    public function __construct(
        public readonly string $type,
        public readonly int $durationDays,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["type"] = $this->type;
        $values["durationDays"] = $this->durationDays;
        return (object) $values;
    }

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
