<?php

declare(strict_types=1);

namespace Commet\Models;

class SubscriptionOfferApplicationPhaseVariant3 extends SubscriptionOfferApplicationPhase implements \JsonSerializable
{
    public function __construct(
        public readonly string $type,
        public readonly int $amount,
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
        $values["amount"] = $this->amount;
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
            amount: $data["amount"],
            durationCycles: $data["duration_cycles"] ?? null,
            durationInterval: $data["duration_interval"] ?? null,
            startsAt: $data["starts_at"] ?? null,
            endsAt: $data["ends_at"] ?? null,
        );
    }
}
