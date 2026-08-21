<?php

declare(strict_types=1);

namespace Commet\Models;

class SubscriptionFeaturesItemVariant4 extends SubscriptionFeaturesItem
{
    public function __construct(
        public readonly string $code,
        public readonly string $name,
        public readonly string $type,
        public readonly ?SubscriptionFeaturesItemVariant4Usage $usage = null,
        public readonly ?SubscriptionFeaturesItemVariant4BaseAccess $baseAccess = null,
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
            usage: isset($data["usage"]) ? SubscriptionFeaturesItemVariant4Usage::fromArray($data["usage"]) : null,
            baseAccess: isset($data["base_access"]) ? SubscriptionFeaturesItemVariant4BaseAccess::fromArray($data["base_access"]) : null,
        );
    }
}
