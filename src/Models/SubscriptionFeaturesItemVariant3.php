<?php

declare(strict_types=1);

namespace Commet\Models;

class SubscriptionFeaturesItemVariant3 extends SubscriptionFeaturesItem
{
    public function __construct(
        public readonly string $code,
        public readonly string $name,
        public readonly string $type,
        public readonly SubscriptionFeaturesItemVariant3Usage $usage,
        public readonly ?SubscriptionFeaturesItemVariant3BaseAccess $baseAccess = null,
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
            usage: SubscriptionFeaturesItemVariant3Usage::fromArray($data["usage"]),
            baseAccess: isset($data["base_access"]) ? SubscriptionFeaturesItemVariant3BaseAccess::fromArray($data["base_access"]) : null,
        );
    }
}
