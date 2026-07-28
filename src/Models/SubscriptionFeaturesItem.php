<?php

declare(strict_types=1);

namespace Commet\Models;

abstract class SubscriptionFeaturesItem
{
    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return match ($data["type"] ?? null) {
            "boolean" => SubscriptionFeaturesItemVariant1::fromArray($data),
            "usage" => SubscriptionFeaturesItemVariant2::fromArray($data),
            "seats" => SubscriptionFeaturesItemVariant3::fromArray($data),
            "quota" => SubscriptionFeaturesItemVariant4::fromArray($data),
            default => SubscriptionFeaturesItemVariant1::fromArray($data),
        };
    }
}
