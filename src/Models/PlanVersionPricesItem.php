<?php

declare(strict_types=1);

namespace Commet\Models;

class PlanVersionPricesItem implements \JsonSerializable
{
    public function __construct(
        public readonly string $id,
        public readonly string $billingInterval,
        public readonly int $price,
        /** @var PlanVersionPricesItemRegionalPricesItem[] */
        public readonly array $regionalPrices,
        public readonly ?int $includedCredits = null,
        public readonly ?int $includedBalance = null,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["id"] = $this->id;
        $values["billingInterval"] = $this->billingInterval;
        $values["price"] = $this->price;
        $values["includedCredits"] = $this->includedCredits;
        $values["includedBalance"] = $this->includedBalance;
        $values["regionalPrices"] = $this->regionalPrices;
        return (object) $values;
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data["id"],
            billingInterval: $data["billing_interval"],
            price: $data["price"],
            regionalPrices: array_map(fn(array $item) => PlanVersionPricesItemRegionalPricesItem::fromArray($item), $data["regional_prices"]),
            includedCredits: $data["included_credits"] ?? null,
            includedBalance: $data["included_balance"] ?? null,
        );
    }
}
