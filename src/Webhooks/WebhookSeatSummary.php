<?php

declare(strict_types=1);

namespace Commet\Webhooks;

final class WebhookSeatSummary
{
    public function __construct(
        public readonly string $code,
        public readonly ?float $current,
        public readonly ?float $included,
        public readonly ?float $remaining,
        public readonly ?bool $unlimited,
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
