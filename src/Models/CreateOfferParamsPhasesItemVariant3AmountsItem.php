<?php

declare(strict_types=1);

namespace Commet\Models;

class CreateOfferParamsPhasesItemVariant3AmountsItem implements \JsonSerializable
{
    public function __construct(
        public readonly string $currency,
        public readonly int $amount,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["currency"] = $this->currency;
        $values["amount"] = $this->amount;
        return (object) $values;
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            currency: $data["currency"],
            amount: $data["amount"],
        );
    }
}
