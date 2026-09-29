<?php

declare(strict_types=1);

namespace Commet\Models;

class FeatureAccessVariant1BaseAccess implements \JsonSerializable
{
    public function __construct(
        public readonly bool $enabled,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["enabled"] = $this->enabled;
        return (object) $values;
    }

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
