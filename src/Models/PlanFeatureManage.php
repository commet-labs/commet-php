<?php

declare(strict_types=1);

namespace Commet\Models;

class PlanFeatureManage
{
    public function __construct(
        public readonly string $planId,
        public readonly string $featureId,
        public readonly bool $enabled,
        public readonly bool $unlimited,
        public readonly bool $overageEnabled,
        public readonly string $pricingMode,
        public readonly ?int $includedAmount = null,
        public readonly ?int $overageUnitPrice = null,
        public readonly ?int $creditsPerUnit = null,
        public readonly ?int $margin = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            planId: $data['plan_id'],
            featureId: $data['feature_id'],
            enabled: $data['enabled'],
            unlimited: $data['unlimited'],
            overageEnabled: $data['overage_enabled'],
            pricingMode: $data['pricing_mode'],
            includedAmount: $data['included_amount'] ?? null,
            overageUnitPrice: $data['overage_unit_price'] ?? null,
            creditsPerUnit: $data['credits_per_unit'] ?? null,
            margin: $data['margin'] ?? null,
        );
    }
}
