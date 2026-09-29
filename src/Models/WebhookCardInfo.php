<?php

declare(strict_types=1);

namespace Commet\Models;

class WebhookCardInfo implements \JsonSerializable
{
    public function __construct(
        public readonly string $brand,
        public readonly string $last4,
        public readonly float $expMonth,
        public readonly float $expYear,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["brand"] = $this->brand;
        $values["last4"] = $this->last4;
        $values["expMonth"] = $this->expMonth;
        $values["expYear"] = $this->expYear;
        return (object) $values;
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            brand: $data["brand"],
            last4: $data["last4"],
            expMonth: $data["exp_month"],
            expYear: $data["exp_year"],
        );
    }
}
