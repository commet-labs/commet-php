<?php

declare(strict_types=1);

namespace Commet\Models;

class PlanGroupDetail
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly bool $isPublic,
        public readonly string $createdAt,
        public readonly string $updatedAt,
        /** @var PlanGroupDetailPlansItem[] */
        public readonly array $plans,
        public readonly string $object,
        public readonly bool $livemode,
        public readonly ?string $description = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data["id"],
            name: $data["name"],
            isPublic: $data["is_public"],
            createdAt: $data["created_at"],
            updatedAt: $data["updated_at"],
            plans: array_map(fn(array $item) => PlanGroupDetailPlansItem::fromArray($item), $data["plans"]),
            object: $data["object"],
            livemode: $data["livemode"],
            description: $data["description"] ?? null,
        );
    }
}
