<?php

declare(strict_types=1);

namespace Commet\Models;

use Commet\Enums\FeatureType;

class ActiveAddon implements \JsonSerializable
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

    public function jsonSerialize(): object
    {
        $values = [];
        $values["slug"] = $this->slug;
        $values["name"] = $this->name;
        $values["basePrice"] = $this->basePrice;
        $values["featureCode"] = $this->featureCode;
        $values["featureName"] = $this->featureName;
        $values["featureType"] = $this->featureType;
        $values["consumptionModel"] = $this->consumptionModel;
        $values["activatedAt"] = $this->activatedAt;
        $values["object"] = $this->object;
        $values["livemode"] = $this->livemode;
        return (object) $values;
    }

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
