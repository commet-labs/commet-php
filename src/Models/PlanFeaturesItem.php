<?php

declare(strict_types=1);

namespace Commet\Models;

use Commet\Enums\FeatureType;

class PlanFeaturesItem implements \JsonSerializable
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

    public function jsonSerialize(): object
    {
        $values = [];
        $values["code"] = $this->code;
        $values["name"] = $this->name;
        $values["type"] = $this->type;
        $values["unitName"] = $this->unitName;
        $values["enabled"] = $this->enabled;
        $values["includedAmount"] = $this->includedAmount;
        $values["unlimited"] = $this->unlimited;
        $values["overage"] = $this->overage;
        $values["regionalPrices"] = $this->regionalPrices;
        return (object) $values;
    }

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
