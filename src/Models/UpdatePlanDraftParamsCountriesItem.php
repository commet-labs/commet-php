<?php

declare(strict_types=1);

namespace Commet\Models;

class UpdatePlanDraftParamsCountriesItem implements \JsonSerializable
{
    public function __construct(
        public readonly string $country,
        public readonly string $currency,
        /** @var UpdatePlanDraftParamsCountriesItemPricesItem[] */
        public readonly array $prices,
        public readonly ?float $exchangeRate = null,
        public readonly ?int $topUpMinimum = null,
        public readonly ?int $maxPlanBalance = null,
        public readonly ?int $planBalanceLimit = null,
        /** @var UpdatePlanDraftParamsCountriesItemAddonPricesItem[]|null */
        public readonly ?array $addonPrices = null,
        /** @var UpdatePlanDraftParamsCountriesItemCreditPackPricesItem[]|null */
        public readonly ?array $creditPackPrices = null,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["country"] = $this->country;
        $values["currency"] = $this->currency;
        if ($this->exchangeRate !== null) {
            $values["exchangeRate"] = $this->exchangeRate;
        }
        $values["prices"] = $this->prices;
        if ($this->topUpMinimum !== null) {
            $values["topUpMinimum"] = $this->topUpMinimum;
        }
        if ($this->maxPlanBalance !== null) {
            $values["maxPlanBalance"] = $this->maxPlanBalance;
        }
        if ($this->planBalanceLimit !== null) {
            $values["planBalanceLimit"] = $this->planBalanceLimit;
        }
        if ($this->addonPrices !== null) {
            $values["addonPrices"] = $this->addonPrices;
        }
        if ($this->creditPackPrices !== null) {
            $values["creditPackPrices"] = $this->creditPackPrices;
        }
        return (object) $values;
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            country: $data["country"],
            currency: $data["currency"],
            prices: array_map(fn(array $item) => UpdatePlanDraftParamsCountriesItemPricesItem::fromArray($item), $data["prices"]),
            exchangeRate: $data["exchange_rate"] ?? null,
            topUpMinimum: $data["top_up_minimum"] ?? null,
            maxPlanBalance: $data["max_plan_balance"] ?? null,
            planBalanceLimit: $data["plan_balance_limit"] ?? null,
            addonPrices: isset($data["addon_prices"]) ? array_map(fn(array $item) => UpdatePlanDraftParamsCountriesItemAddonPricesItem::fromArray($item), $data["addon_prices"]) : null,
            creditPackPrices: isset($data["credit_pack_prices"]) ? array_map(fn(array $item) => UpdatePlanDraftParamsCountriesItemCreditPackPricesItem::fromArray($item), $data["credit_pack_prices"]) : null,
        );
    }
}
