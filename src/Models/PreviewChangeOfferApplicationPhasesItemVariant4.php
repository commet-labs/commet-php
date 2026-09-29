<?php

declare(strict_types=1);

namespace Commet\Models;

class PreviewChangeOfferApplicationPhasesItemVariant4 extends PreviewChangeOfferApplicationPhasesItem implements \JsonSerializable
{
    public function __construct(
        public readonly string $type,
        public readonly int $price,
        public readonly ?int $durationCycles = null,
        public readonly ?string $durationInterval = null,
        public readonly ?string $startsAt = null,
        public readonly ?string $endsAt = null,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["type"] = $this->type;
        $values["durationCycles"] = $this->durationCycles;
        $values["durationInterval"] = $this->durationInterval;
        $values["startsAt"] = $this->startsAt;
        $values["endsAt"] = $this->endsAt;
        $values["price"] = $this->price;
        return (object) $values;
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            type: $data["type"],
            price: $data["price"],
            durationCycles: $data["duration_cycles"] ?? null,
            durationInterval: $data["duration_interval"] ?? null,
            startsAt: $data["starts_at"] ?? null,
            endsAt: $data["ends_at"] ?? null,
        );
    }
}
