<?php

declare(strict_types=1);

namespace Commet\Models;

class WebhookSeatSummary implements \JsonSerializable
{
    public function __construct(
        public readonly string $code,
        public readonly ?float $current = null,
        public readonly ?float $included = null,
        public readonly ?float $remaining = null,
        public readonly ?bool $unlimited = null,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["code"] = $this->code;
        $values["current"] = $this->current;
        $values["included"] = $this->included;
        $values["remaining"] = $this->remaining;
        $values["unlimited"] = $this->unlimited;
        return (object) $values;
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            code: $data["code"],
            current: $data["current"] ?? null,
            included: $data["included"] ?? null,
            remaining: $data["remaining"] ?? null,
            unlimited: $data["unlimited"] ?? null,
        );
    }
}
