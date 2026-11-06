<?php

declare(strict_types=1);

namespace Commet\Models;

class UpdatePlanDraftParamsCountriesItemPricesItemVariant1 extends UpdatePlanDraftParamsCountriesItemPricesItem implements \JsonSerializable
{
    public function __construct(
        public readonly string $billingInterval,
        public readonly int $price,
        public readonly ?int $includedBalance = null,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["billingInterval"] = $this->billingInterval;
        $values["price"] = $this->price;
        if ($this->includedBalance !== null) {
            $values["includedBalance"] = $this->includedBalance;
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
            includedBalance: $data["included_balance"] ?? null,
        );
    }
}
