<?php

declare(strict_types=1);

namespace Commet\Models;

class ActiveAddon
{
    public function __construct(
        public readonly string $object,
        public readonly bool $livemode,
        public readonly string $slug,
        public readonly string $name,
        public readonly int $basePrice,
        public readonly string $featureCode,
        public readonly string $featureName,
        public readonly string $featureType,
        public readonly string $activatedAt,
        public readonly ?string $consumptionModel = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            object: $data['object'] ?? 'addon',
            livemode: $data['livemode'] ?? false,
            slug: $data['slug'],
            name: $data['name'],
            basePrice: $data['base_price'],
            featureCode: $data['feature_code'],
            featureName: $data['feature_name'],
            featureType: $data['feature_type'],
            activatedAt: $data['activated_at'],
            consumptionModel: $data['consumption_model'] ?? null,
        );
    }
}
