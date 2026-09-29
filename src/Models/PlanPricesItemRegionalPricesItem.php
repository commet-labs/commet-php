<?php

declare(strict_types=1);

namespace Commet\Models;

class PlanPricesItemRegionalPricesItem implements \JsonSerializable
{
    public function __construct(
        public readonly string $currency,
        public readonly int $price,
        public readonly bool $autoSynced,
        public readonly ?int $includedBalance = null,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["currency"] = $this->currency;
        $values["price"] = $this->price;
        $values["includedBalance"] = $this->includedBalance;
        $values["autoSynced"] = $this->autoSynced;
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
            autoSynced: $data["auto_synced"],
            includedBalance: $data["included_balance"] ?? null,
        );
    }
}
