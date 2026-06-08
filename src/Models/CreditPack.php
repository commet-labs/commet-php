<?php

declare(strict_types=1);

namespace Commet\Models;

class CreditPack
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly int $credits,
        public readonly int $price,
        public readonly string $object,
        public readonly bool $livemode,
        public readonly ?string $description = null,
        public readonly ?string $currency = null,
        public readonly ?bool $isActive = null,
        public readonly ?string $createdAt = null,
        public readonly ?string $updatedAt = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data["id"],
            name: $data["name"],
            credits: $data["credits"],
            price: $data["price"],
            object: $data["object"],
            livemode: $data["livemode"],
            description: $data["description"] ?? null,
            currency: $data["currency"] ?? null,
            isActive: $data["is_active"] ?? null,
            createdAt: $data["created_at"] ?? null,
            updatedAt: $data["updated_at"] ?? null,
        );
    }
}
