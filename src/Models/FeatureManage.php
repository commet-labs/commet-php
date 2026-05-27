<?php

declare(strict_types=1);

namespace Commet\Models;

use Commet\Enums\FeatureType;

class FeatureManage
{
    public function __construct(
        public readonly string $id,
        public readonly string $object,
        public readonly bool $livemode,
        public readonly string $name,
        public readonly string $code,
        public readonly FeatureType $type,
        public readonly string $createdAt,
        public readonly string $updatedAt,
        public readonly ?string $description = null,
        public readonly ?string $unitName = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            object: $data['object'] ?? 'feature',
            livemode: $data['livemode'] ?? false,
            name: $data['name'],
            code: $data['code'],
            type: FeatureType::from($data['type']),
            createdAt: $data['created_at'],
            updatedAt: $data['updated_at'],
            description: $data['description'] ?? null,
            unitName: $data['unit_name'] ?? null,
        );
    }
}
