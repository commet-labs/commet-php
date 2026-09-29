<?php

declare(strict_types=1);

namespace Commet\Models;

class FeatureAccessVariant2ConsumptionVariant3UnitPrice implements \JsonSerializable
{
    public function __construct(
        public readonly int $amount,
        public readonly string $currency,
        public readonly mixed $scale,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["amount"] = $this->amount;
        $values["currency"] = $this->currency;
        $values["scale"] = $this->scale;
        return (object) $values;
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            amount: $data["amount"],
            currency: $data["currency"],
            scale: $data["scale"],
        );
    }
}
