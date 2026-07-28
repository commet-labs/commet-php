<?php

declare(strict_types=1);

namespace Commet\Models;

use Commet\Enums\FeatureType;

class PlanFeaturesItem
{
    public function __construct(
        public readonly string $code,
        public readonly string $name,
        public readonly FeatureType $type,
        public readonly bool $enabled,
        public readonly bool $unlimited,
        /** @var PlanFeaturesItemRegionalPricesItem[] */
        public readonly array $regionalPrices,
        public readonly ?string $unitName = null,
        public readonly ?int $includedAmount = null,
        public readonly ?PlanFeaturesItemOverage $overage = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            code: $data["code"],
            name: $data["name"],
            type: FeatureType::from($data["type"]),
            enabled: $data["enabled"],
            unlimited: $data["unlimited"],
            regionalPrices: array_map(fn(array $item) => PlanFeaturesItemRegionalPricesItem::fromArray($item), $data["regional_prices"]),
            unitName: $data["unit_name"] ?? null,
            includedAmount: $data["included_amount"] ?? null,
            overage: isset($data["overage"]) ? PlanFeaturesItemOverage::fromArray($data["overage"]) : null,
        );
    }
}
