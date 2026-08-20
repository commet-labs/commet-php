<?php

declare(strict_types=1);

namespace Commet\Models;

class SubscriptionFeaturesItemVariant1BaseAccess
{
    public function __construct(
        public readonly bool $enabled,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            enabled: $data["enabled"],
        );
    }
}
