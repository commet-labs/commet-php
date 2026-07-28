<?php

declare(strict_types=1);

namespace Commet\Models;

class PlanChangeVariant3CurrentPlan
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly int $price,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data["id"],
            name: $data["name"],
            price: $data["price"],
        );
    }
}
