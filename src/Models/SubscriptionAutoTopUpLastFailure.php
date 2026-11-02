<?php

declare(strict_types=1);

namespace Commet\Models;

class SubscriptionAutoTopUpLastFailure implements \JsonSerializable
{
    public function __construct(
        public readonly string $reason,
        public readonly string $at,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["reason"] = $this->reason;
        $values["at"] = $this->at;
        return (object) $values;
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            reason: $data["reason"],
            at: $data["at"],
        );
    }
}
