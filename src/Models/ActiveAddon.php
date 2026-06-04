<?php

declare(strict_types=1);

namespace Commet\Models;

use Commet\Enums\AddonConsumptionModel;
use Commet\Enums\FeatureType;

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
        public readonly FeatureType $featureType,
        public readonly string $activatedAt,
        public readonly ?AddonConsumptionModel $consumptionModel = null,
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
            featureType: FeatureType::from($data['feature_type']),
            activatedAt: $data['activated_at'],
            consumptionModel: isset($data['consumption_model']) ? AddonConsumptionModel::from($data['consumption_model']) : null,
        );
    }
}
