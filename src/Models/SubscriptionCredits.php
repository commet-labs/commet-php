<?php

declare(strict_types=1);

namespace Commet\Models;

class SubscriptionCredits implements \JsonSerializable
{
    public function __construct(
        public readonly bool $unlimited,
        public readonly float $included,
        public readonly float $purchased,
        public readonly ?float $remaining = null,
        public readonly ?float $plan = null,
        public readonly ?float $total = null,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["unlimited"] = $this->unlimited;
        if ($this->remaining !== null) {
            $values["remaining"] = $this->remaining;
        }
        $values["included"] = $this->included;
        $values["purchased"] = $this->purchased;
        if ($this->plan !== null) {
            $values["plan"] = $this->plan;
        }
        if ($this->total !== null) {
            $values["total"] = $this->total;
        }
        return (object) $values;
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            unlimited: $data["unlimited"],
            included: $data["included"],
            purchased: $data["purchased"],
            remaining: $data["remaining"] ?? null,
            plan: $data["plan"] ?? null,
            total: $data["total"] ?? null,
        );
    }
}
