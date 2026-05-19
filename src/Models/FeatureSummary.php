<?php

declare(strict_types=1);

namespace Commet\Models;

use Commet\Enums\FeatureType;

class FeatureSummary
{
    public function __construct(
        public readonly string $code,
        public readonly string $name,
        public readonly FeatureType $type,
        public readonly ?bool $enabled = null,
        /** @var array{current: int, included: int, overage: int, overage_unit_price?: int}|null */
        public readonly ?array $usage = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            code: $data['code'],
            name: $data['name'],
            type: FeatureType::from($data['type']),
            enabled: $data['enabled'] ?? null,
            usage: $data['usage'] ?? null,
        );
    }
}
