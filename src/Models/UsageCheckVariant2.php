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
        public readonly int $planCredits,
        public readonly int $purchasedCredits,
        public readonly int $totalCredits,
        public readonly string $object,
        public readonly bool $livemode,
        public readonly ?string $reason = null,
        public readonly ?string $message = null,
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
        $values["planCredits"] = $this->planCredits;
        $values["purchasedCredits"] = $this->purchasedCredits;
        $values["totalCredits"] = $this->totalCredits;
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
