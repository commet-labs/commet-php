<?php

declare(strict_types=1);

namespace Commet\Models;

class SubscriptionOfferApplicationPhaseVariant1 extends SubscriptionOfferApplicationPhase implements \JsonSerializable
{
    public function __construct(
        public readonly string $type,
        public readonly int $durationDays,
        public readonly ?string $durationInterval = null,
        public readonly ?string $startsAt = null,
        public readonly ?string $endsAt = null,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["type"] = $this->type;
        $values["durationDays"] = $this->durationDays;
        $values["durationInterval"] = $this->durationInterval;
        $values["startsAt"] = $this->startsAt;
        $values["endsAt"] = $this->endsAt;
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
            durationInterval: $data["duration_interval"] ?? null,
            startsAt: $data["starts_at"] ?? null,
            endsAt: $data["ends_at"] ?? null,
        );
    }
}
