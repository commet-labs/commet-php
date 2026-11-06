<?php

declare(strict_types=1);

namespace Commet\Models;

use Commet\Enums\BillingInterval;

class PlanCountriesItemPricesItem implements \JsonSerializable
{
    public function __construct(
        public readonly BillingInterval|string $billingInterval,
        public readonly int $price,
        public readonly bool $manual,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["billingInterval"] = $this->billingInterval;
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
            billingInterval: BillingInterval::tryFrom($data["billing_interval"]) ?? $data["billing_interval"],
            price: $data["price"],
            manual: $data["manual"],
        );
    }
}
