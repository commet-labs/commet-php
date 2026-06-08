<?php

declare(strict_types=1);

namespace Commet\Models;

class PlanFeature
{
    public function __construct(
        public readonly string $planId,
        public readonly string $featureId,
        public readonly bool $enabled,
        public readonly int $includedAmount,
        public readonly bool $unlimited,
        /** @var array<string, mixed> */
        public readonly array $overage,
        public readonly string $pricingMode,
        public readonly string $object,
        public readonly bool $livemode,
        public readonly ?int $creditsPerUnit = null,
        public readonly ?int $margin = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            planId: $data["plan_id"],
            featureId: $data["feature_id"],
            enabled: $data["enabled"],
            includedAmount: $data["included_amount"],
            unlimited: $data["unlimited"],
            overage: $data["overage"],
            pricingMode: $data["pricing_mode"],
            object: $data["object"],
            livemode: $data["livemode"],
            creditsPerUnit: $data["credits_per_unit"] ?? null,
            margin: $data["margin"] ?? null,
        );
    }
}
