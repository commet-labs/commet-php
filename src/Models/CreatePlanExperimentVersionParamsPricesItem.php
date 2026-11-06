<?php

declare(strict_types=1);

namespace Commet\Models;

class CreatePlanExperimentVersionParamsPricesItem implements \JsonSerializable
{
    public function __construct(
        public readonly string $billingInterval,
        public readonly int $price,
        public readonly ?int $includedCredits = null,
        public readonly ?int $includedBalance = null,
        /** @var CreatePlanExperimentVersionParamsPricesItemRegionalPricesItem[]|null */
        public readonly ?array $regionalPrices = null,
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
        if ($this->regionalPrices !== null) {
            $values["regionalPrices"] = $this->regionalPrices;
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
            regionalPrices: isset($data["regional_prices"]) ? array_map(fn(array $item) => CreatePlanExperimentVersionParamsPricesItemRegionalPricesItem::fromArray($item), $data["regional_prices"]) : null,
        );
    }
}
