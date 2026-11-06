<?php

declare(strict_types=1);

namespace Commet\Models;

class UpdatePlanDraftParamsCountriesItemPricesItemVariant2 extends UpdatePlanDraftParamsCountriesItemPricesItem implements \JsonSerializable
{
    public function __construct(
        public readonly string $billingInterval,
        public readonly mixed $followBase,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["billingInterval"] = $this->billingInterval;
        $values["followBase"] = $this->followBase;
        return (object) $values;
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            billingInterval: $data["billing_interval"],
            followBase: $data["follow_base"],
        );
    }
}
