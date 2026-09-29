<?php

declare(strict_types=1);

namespace Commet\Models;

class CreatedSubscriptionPauseVariant1 extends CreatedSubscriptionPause implements \JsonSerializable
{
    public function __construct(
        public readonly string $status,
        public readonly string $mode,
        public readonly string $requestedAt,
        public readonly string $effectiveAt,
        public readonly ?string $resumeAt = null,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["status"] = $this->status;
        $values["mode"] = $this->mode;
        $values["requestedAt"] = $this->requestedAt;
        $values["effectiveAt"] = $this->effectiveAt;
        $values["resumeAt"] = $this->resumeAt;
        return (object) $values;
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            status: $data["status"],
            mode: $data["mode"],
            requestedAt: $data["requested_at"],
            effectiveAt: $data["effective_at"],
            resumeAt: $data["resume_at"] ?? null,
        );
    }
}
