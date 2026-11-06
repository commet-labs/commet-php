<?php

declare(strict_types=1);

namespace Commet\Models;

class UpdatePlanDraftParamsPricesItem implements \JsonSerializable
{
    public function __construct(
        public readonly string $billingInterval,
        public readonly int $price,
        public readonly ?int $includedCredits = null,
        public readonly ?int $includedBalance = null,
        public readonly ?int $trialDays = null,
        public readonly ?bool $trialRequiresPaymentMethod = null,
        public readonly ?bool $isDefault = null,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["billingInterval"] = $this->billingInterval;
        $values["price"] = $this->price;
        if ($this->includedCredits !== null) {
            $values["includedCredits"] = $this->includedCredits;
        }
        if ($this->includedBalance !== null) {
            $values["includedBalance"] = $this->includedBalance;
        }
        if ($this->trialDays !== null) {
            $values["trialDays"] = $this->trialDays;
        }
        if ($this->trialRequiresPaymentMethod !== null) {
            $values["trialRequiresPaymentMethod"] = $this->trialRequiresPaymentMethod;
        }
        if ($this->isDefault !== null) {
            $values["isDefault"] = $this->isDefault;
        }
        return (object) $values;
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            billingInterval: $data["billing_interval"],
            price: $data["price"],
            includedCredits: $data["included_credits"] ?? null,
            includedBalance: $data["included_balance"] ?? null,
            trialDays: $data["trial_days"] ?? null,
            trialRequiresPaymentMethod: $data["trial_requires_payment_method"] ?? null,
            isDefault: $data["is_default"] ?? null,
        );
    }
}
