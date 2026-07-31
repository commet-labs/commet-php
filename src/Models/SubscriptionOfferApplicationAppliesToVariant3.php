<?php

declare(strict_types=1);

namespace Commet\Models;

class SubscriptionOfferApplicationAppliesToVariant3 extends SubscriptionOfferApplicationAppliesTo
{
    public function __construct(
        public readonly string $type,
        public readonly string $id,
    ) {}

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
