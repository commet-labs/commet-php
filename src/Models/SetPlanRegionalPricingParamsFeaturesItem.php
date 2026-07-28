<?php

declare(strict_types=1);

namespace Commet\Models;

class SetPlanRegionalPricingParamsFeaturesItem
{
    public function __construct(
        public readonly string $featureId,
        public readonly int $overageUnitPrice,
    ) {}

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
