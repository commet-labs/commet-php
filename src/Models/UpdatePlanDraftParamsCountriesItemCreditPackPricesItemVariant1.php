<?php

declare(strict_types=1);

namespace Commet\Models;

class UpdatePlanDraftParamsCountriesItemCreditPackPricesItemVariant1 extends UpdatePlanDraftParamsCountriesItemCreditPackPricesItem implements \JsonSerializable
{
    public function __construct(
        public readonly string $creditPackId,
        public readonly int $price,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["creditPackId"] = $this->creditPackId;
        $values["price"] = $this->price;
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
        );
    }
}
