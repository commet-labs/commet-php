<?php

declare(strict_types=1);

namespace Commet\Models;

class UsageCheckVariant3 extends UsageCheck implements \JsonSerializable
{
    public function __construct(
        public readonly bool $allowed,
        public readonly string $subscriptionStatus,
        public readonly string $featureCode,
        public readonly int $quantity,
        public readonly string $consumptionModel,
        public readonly float $unitPrice,
        public readonly float $estimatedAmount,
        public readonly float $currentBalance,
        public readonly bool $blockOnExhaustion,
        public readonly string $currency,
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
        $values["unitPrice"] = $this->unitPrice;
        $values["estimatedAmount"] = $this->estimatedAmount;
        $values["currentBalance"] = $this->currentBalance;
        $values["blockOnExhaustion"] = $this->blockOnExhaustion;
        $values["currency"] = $this->currency;
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
            unitPrice: $data["unit_price"],
            estimatedAmount: $data["estimated_amount"],
            currentBalance: $data["current_balance"],
            blockOnExhaustion: $data["block_on_exhaustion"],
            currency: $data["currency"],
            object: $data["object"],
            livemode: $data["livemode"],
            reason: $data["reason"] ?? null,
            message: $data["message"] ?? null,
        );
    }
}
