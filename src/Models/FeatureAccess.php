<?php

declare(strict_types=1);

namespace Commet\Models;

class FeatureAccess
{
    public function __construct(
        public readonly bool $allowed,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            allowed: $data['allowed'],
        );
    }
}
