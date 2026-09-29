<?php

declare(strict_types=1);

namespace Commet\Models;

class UpsertRegionalPricesParamsOverridesItem implements \JsonSerializable
{
    public function __construct(
        public readonly string $currency,
        public readonly int $price,
        public readonly ?int $includedBalance = null,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["currency"] = $this->currency;
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
            currency: $data["currency"],
            price: $data["price"],
            includedBalance: $data["included_balance"] ?? null,
        );
    }
}
