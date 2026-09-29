<?php

declare(strict_types=1);

namespace Commet\Models;

class SubscriptionPlan implements \JsonSerializable
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly float $basePrice,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["id"] = $this->id;
        $values["name"] = $this->name;
        $values["basePrice"] = $this->basePrice;
        return (object) $values;
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data["id"],
            name: $data["name"],
            basePrice: $data["base_price"],
        );
    }
}
