<?php

declare(strict_types=1);

namespace Commet\Models;

class PlanChangeVariant1OfferApplicationAppliesToVariant1 extends PlanChangeVariant1OfferApplicationAppliesTo implements \JsonSerializable
{
    public function __construct(
        public readonly string $type,
        public readonly string $id,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["type"] = $this->type;
        $values["id"] = $this->id;
        return (object) $values;
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            type: $data["type"],
            id: $data["id"],
        );
    }
}
