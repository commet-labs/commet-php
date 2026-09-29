<?php

declare(strict_types=1);

namespace Commet\Models;

class SubscriptionCurrentPeriod implements \JsonSerializable
{
    public function __construct(
        public readonly string $start,
        public readonly string $end,
        public readonly float $daysRemaining,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["start"] = $this->start;
        $values["end"] = $this->end;
        $values["daysRemaining"] = $this->daysRemaining;
        return (object) $values;
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            start: $data["start"],
            end: $data["end"],
            daysRemaining: $data["days_remaining"],
        );
    }
}
