<?php

declare(strict_types=1);

namespace Commet\Models;

class OfferPhasesItemVariant2 extends OfferPhasesItem implements \JsonSerializable
{
    public function __construct(
        public readonly string $type,
        public readonly int $percentage,
        public readonly ?int $durationCycles = null,
        public readonly ?string $durationInterval = null,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["type"] = $this->type;
        $values["durationCycles"] = $this->durationCycles;
        $values["durationInterval"] = $this->durationInterval;
        $values["percentage"] = $this->percentage;
        return (object) $values;
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            type: $data["type"],
            percentage: $data["percentage"],
            durationCycles: $data["duration_cycles"] ?? null,
            durationInterval: $data["duration_interval"] ?? null,
        );
    }
}
