<?php

declare(strict_types=1);

namespace Commet\Models;

abstract class FeatureAccess
{
    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return match ($data["type"] ?? null) {
            "boolean" => FeatureAccessVariant1::fromArray($data),
            "usage" => FeatureAccessVariant2::fromArray($data),
            "seats" => FeatureAccessVariant3::fromArray($data),
            "quota" => FeatureAccessVariant4::fromArray($data),
            default => FeatureAccessVariant1::fromArray($data),
        };
    }
}
