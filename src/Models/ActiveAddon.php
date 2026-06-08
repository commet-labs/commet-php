<?php

declare(strict_types=1);

namespace Commet\Models;

use Commet\Enums\FeatureType;

class ActiveAddon
{
    public function __construct(
        public readonly string $slug,
        public readonly string $name,
        public readonly int $basePrice,
        public readonly string $featureCode,
        public readonly string $featureName,
        public readonly FeatureType $featureType,
        public readonly string $consumptionModel,
        public readonly string $activatedAt,
        public readonly string $object,
        public readonly bool $livemode,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            slug: $data["slug"],
            name: $data["name"],
            basePrice: $data["base_price"],
            featureCode: $data["feature_code"],
            featureName: $data["feature_name"],
            featureType: FeatureType::from($data["feature_type"]),
            consumptionModel: $data["consumption_model"],
            activatedAt: $data["activated_at"],
            object: $data["object"],
            livemode: $data["livemode"],
        );
    }
}
