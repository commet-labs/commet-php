<?php

declare(strict_types=1);

namespace Commet\Models;

class PlanGroup
{
    /**
     * @param array<int, array{id: string, code: string, name: string, sort_order: int}>|null $plans
     */
    public function __construct(
        public readonly string $id,
        public readonly string $object,
        public readonly bool $livemode,
        public readonly string $name,
        public readonly bool $isPublic,
        public readonly string $createdAt,
        public readonly string $updatedAt,
        public readonly ?string $description = null,
        public readonly ?array $plans = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            object: $data['object'] ?? 'plan_group',
            livemode: $data['livemode'] ?? false,
            name: $data['name'],
            isPublic: $data['is_public'],
            createdAt: $data['created_at'],
            updatedAt: $data['updated_at'],
            description: $data['description'] ?? null,
            plans: $data['plans'] ?? null,
        );
    }
}
