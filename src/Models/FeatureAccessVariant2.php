<?php

declare(strict_types=1);

namespace Commet\Models;

class FeatureAccessVariant2 extends FeatureAccess
{
    public function __construct(
        public readonly string $code,
        public readonly string $name,
        public readonly bool $allowed,
        public readonly string $type,
        public readonly FeatureAccessVariant2Consumption $consumption,
        public readonly string $object,
        public readonly bool $livemode,
        public readonly ?string $unitName = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            code: $data["code"],
            name: $data["name"],
            allowed: $data["allowed"],
            type: $data["type"],
            consumption: FeatureAccessVariant2Consumption::fromArray($data["consumption"]),
            object: $data["object"],
            livemode: $data["livemode"],
            unitName: $data["unit_name"] ?? null,
        );
    }
}
