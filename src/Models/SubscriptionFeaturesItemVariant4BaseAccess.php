<?php

declare(strict_types=1);

namespace Commet\Models;

class SubscriptionFeaturesItemVariant4BaseAccess
{
    public function __construct(
        public readonly float $included,
        public readonly bool $unlimited,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            included: $data["included"],
            unlimited: $data["unlimited"],
        );
    }
}
