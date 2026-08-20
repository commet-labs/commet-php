<?php

declare(strict_types=1);

namespace Commet\Models;

class WebhookPlanGrantTimelineEvent
{
    public function __construct(
        public readonly string $id,
        public readonly string $type,
        public readonly string $reason,
        public readonly string $source,
        public readonly string $createdAt,
        public readonly ?string $previousExpiresAt = null,
        public readonly ?string $expiresAt = null,
        public readonly ?string $duration = null,
        public readonly ?int $durationCycles = null,
        public readonly ?string $requestedExpiresAt = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data["id"],
            type: $data["type"],
            reason: $data["reason"],
            source: $data["source"],
            createdAt: $data["created_at"],
            previousExpiresAt: $data["previous_expires_at"] ?? null,
            expiresAt: $data["expires_at"] ?? null,
            duration: $data["duration"] ?? null,
            durationCycles: $data["duration_cycles"] ?? null,
            requestedExpiresAt: $data["requested_expires_at"] ?? null,
        );
    }
}
