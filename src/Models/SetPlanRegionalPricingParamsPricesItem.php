<?php

declare(strict_types=1);

namespace Commet\Models;

class SetPlanRegionalPricingParamsPricesItem implements \JsonSerializable
{
    public function __construct(
        public readonly string $priceId,
        public readonly int $price,
        public readonly ?int $includedBalance = null,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["priceId"] = $this->priceId;
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
            priceId: $data["price_id"],
            price: $data["price"],
            includedBalance: $data["included_balance"] ?? null,
        );
    }
}
