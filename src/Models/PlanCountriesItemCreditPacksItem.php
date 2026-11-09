<?php

declare(strict_types=1);

namespace Commet\Models;

class PlanCountriesItemCreditPacksItem implements \JsonSerializable
{
    public function __construct(
        public readonly string $creditPackId,
        public readonly int $price,
        public readonly bool $manual,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["creditPackId"] = $this->creditPackId;
        $values["price"] = $this->price;
        $values["manual"] = $this->manual;
        return (object) $values;
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            creditPackId: $data["credit_pack_id"],
            price: $data["price"],
            manual: $data["manual"],
        );
    }
}
