<?php

declare(strict_types=1);

namespace Commet\Models;

class UpdatePlanDraftParamsRules implements \JsonSerializable
{
    public function __construct(
        public readonly ?int $freeIncludedCredits = null,
        public readonly ?int $freeIncludedBalance = null,
        public readonly ?string $unusedPlanCredits = null,
        public readonly ?int $maxPlanCredits = null,
        public readonly ?int $planCreditLimit = null,
        public readonly ?string $planCreditLimitInterval = null,
        public readonly ?string $unusedPlanBalance = null,
        public readonly ?int $maxPlanBalance = null,
        public readonly ?int $planBalanceLimit = null,
        public readonly ?string $planBalanceLimitInterval = null,
        public readonly ?bool $blockOnExhaustion = null,
        public readonly ?bool $purchasesEnabled = null,
        public readonly ?int $creditPurchaseUnitPrice = null,
        public readonly ?int $creditPurchaseMinimum = null,
        public readonly ?int $topUpMinimum = null,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        if ($this->freeIncludedCredits !== null) {
            $values["freeIncludedCredits"] = $this->freeIncludedCredits;
        }
        if ($this->freeIncludedBalance !== null) {
            $values["freeIncludedBalance"] = $this->freeIncludedBalance;
        }
        if ($this->unusedPlanCredits !== null) {
            $values["unusedPlanCredits"] = $this->unusedPlanCredits;
        }
        if ($this->maxPlanCredits !== null) {
            $values["maxPlanCredits"] = $this->maxPlanCredits;
        }
        if ($this->planCreditLimit !== null) {
            $values["planCreditLimit"] = $this->planCreditLimit;
        }
        if ($this->planCreditLimitInterval !== null) {
            $values["planCreditLimitInterval"] = $this->planCreditLimitInterval;
        }
        if ($this->unusedPlanBalance !== null) {
            $values["unusedPlanBalance"] = $this->unusedPlanBalance;
        }
        if ($this->maxPlanBalance !== null) {
            $values["maxPlanBalance"] = $this->maxPlanBalance;
        }
        if ($this->planBalanceLimit !== null) {
            $values["planBalanceLimit"] = $this->planBalanceLimit;
        }
        if ($this->planBalanceLimitInterval !== null) {
            $values["planBalanceLimitInterval"] = $this->planBalanceLimitInterval;
        }
        if ($this->blockOnExhaustion !== null) {
            $values["blockOnExhaustion"] = $this->blockOnExhaustion;
        }
        if ($this->purchasesEnabled !== null) {
            $values["purchasesEnabled"] = $this->purchasesEnabled;
        }
        if ($this->creditPurchaseUnitPrice !== null) {
            $values["creditPurchaseUnitPrice"] = $this->creditPurchaseUnitPrice;
        }
        if ($this->creditPurchaseMinimum !== null) {
            $values["creditPurchaseMinimum"] = $this->creditPurchaseMinimum;
        }
        if ($this->topUpMinimum !== null) {
            $values["topUpMinimum"] = $this->topUpMinimum;
        }
        return (object) $values;
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            freeIncludedCredits: $data["free_included_credits"] ?? null,
            freeIncludedBalance: $data["free_included_balance"] ?? null,
            unusedPlanCredits: $data["unused_plan_credits"] ?? null,
            maxPlanCredits: $data["max_plan_credits"] ?? null,
            planCreditLimit: $data["plan_credit_limit"] ?? null,
            planCreditLimitInterval: $data["plan_credit_limit_interval"] ?? null,
            unusedPlanBalance: $data["unused_plan_balance"] ?? null,
            maxPlanBalance: $data["max_plan_balance"] ?? null,
            planBalanceLimit: $data["plan_balance_limit"] ?? null,
            planBalanceLimitInterval: $data["plan_balance_limit_interval"] ?? null,
            blockOnExhaustion: $data["block_on_exhaustion"] ?? null,
            purchasesEnabled: $data["purchases_enabled"] ?? null,
            creditPurchaseUnitPrice: $data["credit_purchase_unit_price"] ?? null,
            creditPurchaseMinimum: $data["credit_purchase_minimum"] ?? null,
            topUpMinimum: $data["top_up_minimum"] ?? null,
        );
    }
}
