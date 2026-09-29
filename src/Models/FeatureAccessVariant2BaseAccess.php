<?php

declare(strict_types=1);

namespace Commet\Models;

class FeatureAccessVariant2BaseAccess implements \JsonSerializable
{
    public function __construct(
        public readonly float $includedUnits,
        public readonly bool $unlimited,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["includedUnits"] = $this->includedUnits;
        $values["unlimited"] = $this->unlimited;
        return (object) $values;
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            includedUnits: $data["included_units"],
            unlimited: $data["unlimited"],
        );
    }
}
