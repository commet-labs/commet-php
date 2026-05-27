<?php

declare(strict_types=1);

namespace Commet\Models;

class PlanManage
{
    /**
     * @param array<string, mixed>|null $metadata
     */
    public function __construct(
        public readonly string $id,
        public readonly string $object,
        public readonly bool $livemode,
        public readonly string $name,
        public readonly string $code,
        public readonly bool $isPublic,
        public readonly bool $isDefault,
        public readonly bool $isFree,
        public readonly bool $blockOnExhaustion,
        public readonly int $sortOrder,
        public readonly string $createdAt,
        public readonly string $updatedAt,
        public readonly ?string $description = null,
        public readonly ?string $consumptionModel = null,
        public readonly ?string $planGroupId = null,
        public readonly ?array $metadata = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            object: $data['object'] ?? 'plan',
            livemode: $data['livemode'] ?? false,
            name: $data['name'],
            code: $data['code'],
            isPublic: $data['is_public'],
            isDefault: $data['is_default'],
            isFree: $data['is_free'],
            blockOnExhaustion: $data['block_on_exhaustion'],
            sortOrder: $data['sort_order'],
            createdAt: $data['created_at'],
            updatedAt: $data['updated_at'],
            description: $data['description'] ?? null,
            consumptionModel: $data['consumption_model'] ?? null,
            planGroupId: $data['plan_group_id'] ?? null,
            metadata: $data['metadata'] ?? null,
        );
    }
}
