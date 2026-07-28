<?php

declare(strict_types=1);

namespace Commet\Models;

class UsageCheckVariant1 extends UsageCheck
{
    public function __construct(
        public readonly bool $allowed,
        public readonly string $subscriptionStatus,
        public readonly string $featureCode,
        public readonly int $quantity,
        public readonly string $consumptionModel,
        public readonly float $current,
        public readonly float $remaining,
        public readonly bool $unlimited,
        public readonly float $included,
        public readonly bool $overageEnabled,
        public readonly string $object,
        public readonly bool $livemode,
        public readonly ?string $reason = null,
        public readonly ?string $message = null,
        public readonly ?float $overageUnitPrice = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            allowed: $data["allowed"],
            subscriptionStatus: $data["subscription_status"],
            featureCode: $data["feature_code"],
            quantity: $data["quantity"],
            consumptionModel: $data["consumption_model"],
            current: $data["current"],
            remaining: $data["remaining"],
            unlimited: $data["unlimited"],
            included: $data["included"],
            overageEnabled: $data["overage_enabled"],
            object: $data["object"],
            livemode: $data["livemode"],
            reason: $data["reason"] ?? null,
            message: $data["message"] ?? null,
            overageUnitPrice: $data["overage_unit_price"] ?? null,
        );
    }
}
