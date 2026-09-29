<?php

declare(strict_types=1);

namespace Commet\Models;

class SubscriptionFeaturesItemVariant3BaseAccess implements \JsonSerializable
{
    public function __construct(
        public readonly float $included,
        public readonly bool $unlimited,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["included"] = $this->included;
        $values["unlimited"] = $this->unlimited;
        return (object) $values;
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            included: $data["included"],
            unlimited: $data["unlimited"],
        );
    }
}
