<?php

declare(strict_types=1);

namespace Commet\Models;

class UsageCheckVariant2 extends UsageCheck implements \JsonSerializable
{
    public function __construct(
        public readonly bool $allowed,
        public readonly string $subscriptionStatus,
        public readonly string $featureCode,
        public readonly int $quantity,
        public readonly string $consumptionModel,
        public readonly int $creditsPerUnit,
        public readonly int $estimatedCredits,
        public readonly bool $unlimited,
        public readonly int $purchasedCredits,
        public readonly bool $blockOnExhaustion,
        public readonly string $object,
        public readonly bool $livemode,
        public readonly ?string $reason = null,
        public readonly ?string $message = null,
        public readonly ?int $planCredits = null,
        public readonly ?int $totalCredits = null,
        public readonly ?UsageCheckVariant2PlanCreditLimit $planCreditLimit = null,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["allowed"] = $this->allowed;
        $values["subscriptionStatus"] = $this->subscriptionStatus;
        $values["featureCode"] = $this->featureCode;
        $values["quantity"] = $this->quantity;
        if ($this->reason !== null) {
            $values["reason"] = $this->reason;
        }
        if ($this->message !== null) {
            $values["message"] = $this->message;
        }
        $values["consumptionModel"] = $this->consumptionModel;
        $values["creditsPerUnit"] = $this->creditsPerUnit;
        $values["estimatedCredits"] = $this->estimatedCredits;
        $values["unlimited"] = $this->unlimited;
        if ($this->planCredits !== null) {
            $values["planCredits"] = $this->planCredits;
        }
        $values["purchasedCredits"] = $this->purchasedCredits;
        if ($this->totalCredits !== null) {
            $values["totalCredits"] = $this->totalCredits;
        }
        $values["planCreditLimit"] = $this->planCreditLimit;
        $values["blockOnExhaustion"] = $this->blockOnExhaustion;
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
            allowed: $data["allowed"],
            subscriptionStatus: $data["subscription_status"],
            featureCode: $data["feature_code"],
            quantity: $data["quantity"],
            consumptionModel: $data["consumption_model"],
            creditsPerUnit: $data["credits_per_unit"],
            estimatedCredits: $data["estimated_credits"],
            unlimited: $data["unlimited"],
            purchasedCredits: $data["purchased_credits"],
            blockOnExhaustion: $data["block_on_exhaustion"],
            object: $data["object"],
            livemode: $data["livemode"],
            reason: $data["reason"] ?? null,
            message: $data["message"] ?? null,
            planCredits: $data["plan_credits"] ?? null,
            totalCredits: $data["total_credits"] ?? null,
            planCreditLimit: isset($data["plan_credit_limit"]) ? UsageCheckVariant2PlanCreditLimit::fromArray($data["plan_credit_limit"]) : null,
        );
    }
}
