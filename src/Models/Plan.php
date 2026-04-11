<?php

declare(strict_types=1);

namespace Commet\Models;

class Plan
{
    /**
     * @param PlanPrice[] $prices
     * @param PlanFeature[] $features
     */
    public function __construct(
        public readonly string $id,
        public readonly string $code,
        public readonly string $name,
        public readonly bool $isPublic,
        public readonly bool $isDefault,
        public readonly int $sortOrder,
        public readonly array $prices,
        public readonly array $features,
        public readonly string $createdAt,
        public readonly ?string $description = null,
        public readonly ?bool $isFree = null,
        public readonly ?string $updatedAt = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        $prices = array_map(
            fn(array $price) => PlanPrice::fromArray($price),
            $data['prices'] ?? [],
        );

        $features = array_map(
            fn(array $feature) => PlanFeature::fromArray($feature),
            $data['features'] ?? [],
        );

        return new self(
            id: $data['id'],
            code: $data['code'],
            name: $data['name'],
            isPublic: $data['is_public'],
            isDefault: $data['is_default'],
            sortOrder: $data['sort_order'],
            prices: $prices,
            features: $features,
            createdAt: $data['created_at'],
            description: $data['description'] ?? null,
            isFree: $data['is_free'] ?? null,
            updatedAt: $data['updated_at'] ?? null,
        );
    }
}
