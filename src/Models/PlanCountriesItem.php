<?php

declare(strict_types=1);

namespace Commet\Models;

class PlanCountriesItem implements \JsonSerializable
{
    public function __construct(
        public readonly string $country,
        public readonly string $currency,
        /** @var PlanCountriesItemPricesItem[] */
        public readonly array $prices,
        /** @var PlanCountriesItemAddonsItem[] */
        public readonly array $addons,
        /** @var PlanCountriesItemCreditPacksItem[] */
        public readonly array $creditPacks,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["country"] = $this->country;
        $values["currency"] = $this->currency;
        $values["prices"] = $this->prices;
        $values["addons"] = $this->addons;
        $values["creditPacks"] = $this->creditPacks;
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
            prices: array_map(fn(array $item) => PlanCountriesItemPricesItem::fromArray($item), $data["prices"]),
            addons: array_map(fn(array $item) => PlanCountriesItemAddonsItem::fromArray($item), $data["addons"]),
            creditPacks: array_map(fn(array $item) => PlanCountriesItemCreditPacksItem::fromArray($item), $data["credit_packs"]),
        );
    }
}
