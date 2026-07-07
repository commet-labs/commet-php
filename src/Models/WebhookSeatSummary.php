<?php

declare(strict_types=1);

namespace Commet\Models;

class WebhookSeatSummary
{
    public function __construct(
        public readonly string $code,
        public readonly ?float $current = null,
        public readonly ?float $included = null,
        public readonly ?float $remaining = null,
        public readonly ?bool $unlimited = null,
    ) {}

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
