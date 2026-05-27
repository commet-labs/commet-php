<?php

declare(strict_types=1);

namespace Commet\Models;

class FeatureAccess
{
    public function __construct(
        public readonly bool $allowed,
        public readonly bool $willBeCharged,
        public readonly ?string $reason = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            allowed: $data['allowed'],
            willBeCharged: $data['will_be_charged'],
            reason: $data['reason'] ?? null,
        );
    }
}
