<?php

declare(strict_types=1);

namespace Commet\Models;

class SubscriptionCredits implements \JsonSerializable
{
    public function __construct(
        public readonly float $remaining,
        public readonly float $included,
        public readonly float $purchased,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["remaining"] = $this->remaining;
        $values["included"] = $this->included;
        $values["purchased"] = $this->purchased;
        return (object) $values;
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            remaining: $data["remaining"],
            included: $data["included"],
            purchased: $data["purchased"],
        );
    }
}
