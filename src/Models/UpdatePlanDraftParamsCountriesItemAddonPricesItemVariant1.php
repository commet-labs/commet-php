<?php

declare(strict_types=1);

namespace Commet\Models;

class UpdatePlanDraftParamsCountriesItemAddonPricesItemVariant1 extends UpdatePlanDraftParamsCountriesItemAddonPricesItem implements \JsonSerializable
{
    public function __construct(
        public readonly string $addonId,
        public readonly int $price,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["addonId"] = $this->addonId;
        $values["price"] = $this->price;
        return (object) $values;
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            addonId: $data["addon_id"],
            price: $data["price"],
        );
    }
}
