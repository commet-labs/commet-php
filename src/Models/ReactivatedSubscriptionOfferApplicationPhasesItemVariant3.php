<?php

declare(strict_types=1);

namespace Commet\Models;

class ReactivatedSubscriptionOfferApplicationPhasesItemVariant3 extends ReactivatedSubscriptionOfferApplicationPhasesItem
{
    public function __construct(
        public readonly string $type,
        public readonly int $amount,
        public readonly ?int $durationCycles = null,
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
            amount: $data["amount"],
            durationCycles: $data["duration_cycles"] ?? null,
            startsAt: $data["starts_at"] ?? null,
            endsAt: $data["ends_at"] ?? null,
        );
    }
}
