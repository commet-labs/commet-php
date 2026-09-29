<?php

declare(strict_types=1);

namespace Commet\Models;

class SubscriptionSummaryCancellation implements \JsonSerializable
{
    public function __construct(
        public readonly string $scheduledAt,
        public readonly string $effectiveAt,
        public readonly ?string $reason = null,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["scheduledAt"] = $this->scheduledAt;
        $values["reason"] = $this->reason;
        $values["effectiveAt"] = $this->effectiveAt;
        return (object) $values;
    }

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
