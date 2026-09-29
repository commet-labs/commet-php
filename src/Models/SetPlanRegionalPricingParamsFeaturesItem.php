<?php

declare(strict_types=1);

namespace Commet\Models;

class SetPlanRegionalPricingParamsFeaturesItem implements \JsonSerializable
{
    public function __construct(
        public readonly string $featureId,
        public readonly int $overageUnitPrice,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["featureId"] = $this->featureId;
        $values["overageUnitPrice"] = $this->overageUnitPrice;
        return (object) $values;
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            featureId: $data["feature_id"],
            overageUnitPrice: $data["overage_unit_price"],
        );
    }
}
