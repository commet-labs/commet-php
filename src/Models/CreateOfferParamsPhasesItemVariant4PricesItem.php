<?php

declare(strict_types=1);

namespace Commet\Models;

class CreateOfferParamsPhasesItemVariant4PricesItem
{
    public function __construct(
        public readonly string $currency,
        public readonly int $amount,
    ) {}

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
