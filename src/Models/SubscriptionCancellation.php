<?php

declare(strict_types=1);

namespace Commet\Models;

class SubscriptionCancellation
{
    public function __construct(
        public readonly string $scheduledAt,
        public readonly string $effectiveAt,
        public readonly ?string $reason = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            scheduledAt: $data["scheduled_at"],
            effectiveAt: $data["effective_at"],
            reason: $data["reason"] ?? null,
        );
    }
}
