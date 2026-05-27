<?php

declare(strict_types=1);

namespace Commet\Models;

class CreditPackDetail
{
    public function __construct(
        public readonly string $id,
        public readonly string $object,
        public readonly bool $livemode,
        public readonly string $name,
        public readonly int $credits,
        public readonly int $price,
        public readonly bool $isActive,
        public readonly string $createdAt,
        public readonly string $updatedAt,
        public readonly ?string $description = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            object: $data['object'] ?? 'credit_pack',
            livemode: $data['livemode'] ?? false,
            name: $data['name'],
            credits: $data['credits'],
            price: $data['price'],
            isActive: $data['is_active'],
            createdAt: $data['created_at'],
            updatedAt: $data['updated_at'],
            description: $data['description'] ?? null,
        );
    }
}
