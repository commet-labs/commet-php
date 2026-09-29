<?php

declare(strict_types=1);

namespace Commet\Models;

class UpdateCustomerParamsAddress implements \JsonSerializable
{
    public function __construct(
        public readonly string $line1,
        public readonly string $city,
        public readonly string $postalCode,
        public readonly string $country,
        public readonly ?string $line2 = null,
        public readonly ?string $state = null,
        public readonly ?string $region = null,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["line1"] = $this->line1;
        if ($this->line2 !== null) {
            $values["line2"] = $this->line2;
        }
        $values["city"] = $this->city;
        if ($this->state !== null) {
            $values["state"] = $this->state;
        }
        $values["postalCode"] = $this->postalCode;
        $values["country"] = $this->country;
        if ($this->region !== null) {
            $values["region"] = $this->region;
        }
        return (object) $values;
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            line1: $data["line1"],
            city: $data["city"],
            postalCode: $data["postal_code"],
            country: $data["country"],
            line2: $data["line2"] ?? null,
            state: $data["state"] ?? null,
            region: $data["region"] ?? null,
        );
    }
}
