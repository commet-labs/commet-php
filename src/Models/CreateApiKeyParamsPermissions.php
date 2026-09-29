<?php

declare(strict_types=1);

namespace Commet\Models;

class CreateApiKeyParamsPermissions implements \JsonSerializable
{
    public function __construct(
        /** @var string[]|null */
        public readonly ?array $customer = null,
        /** @var string[]|null */
        public readonly ?array $subscription = null,
        /** @var string[]|null */
        public readonly ?array $invoice = null,
        /** @var string[]|null */
        public readonly ?array $usage = null,
        /** @var string[]|null */
        public readonly ?array $seat = null,
        /** @var string[]|null */
        public readonly ?array $plan = null,
        /** @var string[]|null */
        public readonly ?array $planGroup = null,
        /** @var string[]|null */
        public readonly ?array $feature = null,
        /** @var string[]|null */
        public readonly ?array $addon = null,
        /** @var string[]|null */
        public readonly ?array $creditPack = null,
        /** @var string[]|null */
        public readonly ?array $offer = null,
        /** @var string[]|null */
        public readonly ?array $promoCode = null,
        /** @var string[]|null */
        public readonly ?array $marketGroup = null,
        /** @var string[]|null */
        public readonly ?array $payment = null,
        /** @var string[]|null */
        public readonly ?array $transaction = null,
        /** @var string[]|null */
        public readonly ?array $payout = null,
        /** @var string[]|null */
        public readonly ?array $testClock = null,
        /** @var string[]|null */
        public readonly ?array $organization = null,
        /** @var string[]|null */
        public readonly ?array $apiKey = null,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        if ($this->customer !== null) {
            $values["customer"] = $this->customer;
        }
        if ($this->subscription !== null) {
            $values["subscription"] = $this->subscription;
        }
        if ($this->invoice !== null) {
            $values["invoice"] = $this->invoice;
        }
        if ($this->usage !== null) {
            $values["usage"] = $this->usage;
        }
        if ($this->seat !== null) {
            $values["seat"] = $this->seat;
        }
        if ($this->plan !== null) {
            $values["plan"] = $this->plan;
        }
        if ($this->planGroup !== null) {
            $values["plan_group"] = $this->planGroup;
        }
        if ($this->feature !== null) {
            $values["feature"] = $this->feature;
        }
        if ($this->addon !== null) {
            $values["addon"] = $this->addon;
        }
        if ($this->creditPack !== null) {
            $values["credit_pack"] = $this->creditPack;
        }
        if ($this->offer !== null) {
            $values["offer"] = $this->offer;
        }
        if ($this->promoCode !== null) {
            $values["promo_code"] = $this->promoCode;
        }
        if ($this->marketGroup !== null) {
            $values["market_group"] = $this->marketGroup;
        }
        if ($this->payment !== null) {
            $values["payment"] = $this->payment;
        }
        if ($this->transaction !== null) {
            $values["transaction"] = $this->transaction;
        }
        if ($this->payout !== null) {
            $values["payout"] = $this->payout;
        }
        if ($this->testClock !== null) {
            $values["test_clock"] = $this->testClock;
        }
        if ($this->organization !== null) {
            $values["organization"] = $this->organization;
        }
        if ($this->apiKey !== null) {
            $values["api_key"] = $this->apiKey;
        }
        return (object) $values;
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            customer: $data["customer"] ?? null,
            subscription: $data["subscription"] ?? null,
            invoice: $data["invoice"] ?? null,
            usage: $data["usage"] ?? null,
            seat: $data["seat"] ?? null,
            plan: $data["plan"] ?? null,
            planGroup: $data["plan_group"] ?? null,
            feature: $data["feature"] ?? null,
            addon: $data["addon"] ?? null,
            creditPack: $data["credit_pack"] ?? null,
            offer: $data["offer"] ?? null,
            promoCode: $data["promo_code"] ?? null,
            marketGroup: $data["market_group"] ?? null,
            payment: $data["payment"] ?? null,
            transaction: $data["transaction"] ?? null,
            payout: $data["payout"] ?? null,
            testClock: $data["test_clock"] ?? null,
            organization: $data["organization"] ?? null,
            apiKey: $data["api_key"] ?? null,
        );
    }
}
