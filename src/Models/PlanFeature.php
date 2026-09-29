<?php

declare(strict_types=1);

namespace Commet\Models;

class PlanFeature implements \JsonSerializable
{
    public function __construct(
        public readonly string $planId,
        public readonly string $featureId,
        public readonly bool $enabled,
        public readonly int $includedAmount,
        public readonly bool $unlimited,
        public readonly PlanFeatureOverage $overage,
        public readonly string $pricingMode,
        public readonly string $object,
        public readonly bool $livemode,
        public readonly ?int $creditsPerUnit = null,
        public readonly ?int $margin = null,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["planId"] = $this->planId;
        $values["featureId"] = $this->featureId;
        $values["enabled"] = $this->enabled;
        $values["includedAmount"] = $this->includedAmount;
        $values["unlimited"] = $this->unlimited;
        $values["overage"] = $this->overage;
        $values["creditsPerUnit"] = $this->creditsPerUnit;
        $values["pricingMode"] = $this->pricingMode;
        $values["margin"] = $this->margin;
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
            planId: $data["plan_id"],
            featureId: $data["feature_id"],
            enabled: $data["enabled"],
            includedAmount: $data["included_amount"],
            unlimited: $data["unlimited"],
            overage: PlanFeatureOverage::fromArray($data["overage"]),
            pricingMode: $data["pricing_mode"],
            object: $data["object"],
            livemode: $data["livemode"],
            creditsPerUnit: $data["credits_per_unit"] ?? null,
            margin: $data["margin"] ?? null,
        );
    }
}
