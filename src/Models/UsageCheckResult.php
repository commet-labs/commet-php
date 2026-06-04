<?php

declare(strict_types=1);

namespace Commet\Models;

use Commet\Enums\ConsumptionModel;
use Commet\Enums\UsageCheckDenialReason;

class UsageCheckResult
{
    public function __construct(
        public readonly bool $allowed,
        public readonly ConsumptionModel $consumptionModel,
        public readonly string $feature,
        public readonly int $quantity,
        public readonly ?int $current = null,
        public readonly ?int $remaining = null,
        public readonly ?bool $unlimited = null,
        public readonly ?int $included = null,
        public readonly ?bool $overageEnabled = null,
        public readonly ?int $overageUnitPrice = null,
        public readonly ?int $creditsPerUnit = null,
        public readonly ?int $estimatedCredits = null,
        public readonly ?int $planCredits = null,
        public readonly ?int $purchasedCredits = null,
        public readonly ?int $totalCredits = null,
        public readonly ?int $unitPrice = null,
        public readonly ?int $estimatedAmount = null,
        public readonly ?int $currentBalance = null,
        public readonly ?bool $blockOnExhaustion = null,
        public readonly ?string $currency = null,
        public readonly ?UsageCheckDenialReason $reason = null,
        public readonly ?string $message = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            allowed: $data['allowed'],
            consumptionModel: ConsumptionModel::from($data['consumption_model']),
            feature: $data['feature'],
            quantity: $data['quantity'],
            current: $data['current'] ?? null,
            remaining: $data['remaining'] ?? null,
            unlimited: $data['unlimited'] ?? null,
            included: $data['included'] ?? null,
            overageEnabled: $data['overage_enabled'] ?? null,
            overageUnitPrice: $data['overage_unit_price'] ?? null,
            creditsPerUnit: $data['credits_per_unit'] ?? null,
            estimatedCredits: $data['estimated_credits'] ?? null,
            planCredits: $data['plan_credits'] ?? null,
            purchasedCredits: $data['purchased_credits'] ?? null,
            totalCredits: $data['total_credits'] ?? null,
            unitPrice: $data['unit_price'] ?? null,
            estimatedAmount: $data['estimated_amount'] ?? null,
            currentBalance: $data['current_balance'] ?? null,
            blockOnExhaustion: $data['block_on_exhaustion'] ?? null,
            currency: $data['currency'] ?? null,
            reason: isset($data['reason']) ? UsageCheckDenialReason::from($data['reason']) : null,
            message: $data['message'] ?? null,
        );
    }
}
