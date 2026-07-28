<?php

declare(strict_types=1);

namespace Commet\Models;

class UsageCheckVariant2 extends UsageCheck
{
    public function __construct(
        public readonly bool $allowed,
        public readonly string $subscriptionStatus,
        public readonly string $featureCode,
        public readonly int $quantity,
        public readonly string $consumptionModel,
        public readonly int $creditsPerUnit,
        public readonly int $estimatedCredits,
        public readonly int $planCredits,
        public readonly int $purchasedCredits,
        public readonly int $totalCredits,
        public readonly string $object,
        public readonly bool $livemode,
        public readonly ?string $reason = null,
        public readonly ?string $message = null,
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
            creditsPerUnit: $data["credits_per_unit"],
            estimatedCredits: $data["estimated_credits"],
            planCredits: $data["plan_credits"],
            purchasedCredits: $data["purchased_credits"],
            totalCredits: $data["total_credits"],
            object: $data["object"],
            livemode: $data["livemode"],
            reason: $data["reason"] ?? null,
            message: $data["message"] ?? null,
        );
    }
}
