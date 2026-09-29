<?php

declare(strict_types=1);

namespace Commet\Models;

class UsageEventConsumption implements \JsonSerializable
{
    public function __construct(
        public readonly string $model,
        public readonly float $deducted,
        public readonly float $remaining,
        public readonly bool $blocked,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["model"] = $this->model;
        $values["deducted"] = $this->deducted;
        $values["remaining"] = $this->remaining;
        $values["blocked"] = $this->blocked;
        return (object) $values;
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            model: $data["model"],
            deducted: $data["deducted"],
            remaining: $data["remaining"],
            blocked: $data["blocked"],
        );
    }
}
