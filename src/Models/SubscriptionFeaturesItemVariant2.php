<?php

declare(strict_types=1);

namespace Commet\Models;

class SubscriptionFeaturesItemVariant2 extends SubscriptionFeaturesItem
{
    public function __construct(
        public readonly string $code,
        public readonly string $name,
        public readonly string $type,
        public readonly ?SubscriptionFeaturesItemVariant2Usage $usage = null,
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
            usage: isset($data["usage"]) ? SubscriptionFeaturesItemVariant2Usage::fromArray($data["usage"]) : null,
        );
    }
}
