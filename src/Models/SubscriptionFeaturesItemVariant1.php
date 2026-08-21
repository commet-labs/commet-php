<?php

declare(strict_types=1);

namespace Commet\Models;

class SubscriptionFeaturesItemVariant1 extends SubscriptionFeaturesItem
{
    public function __construct(
        public readonly string $code,
        public readonly string $name,
        public readonly string $type,
        public readonly bool $enabled,
        public readonly ?SubscriptionFeaturesItemVariant1BaseAccess $baseAccess = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            code: $data["code"],
            name: $data["name"],
            type: $data["type"],
            enabled: $data["enabled"],
            baseAccess: isset($data["base_access"]) ? SubscriptionFeaturesItemVariant1BaseAccess::fromArray($data["base_access"]) : null,
        );
    }
}
