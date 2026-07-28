<?php

declare(strict_types=1);

namespace Commet\Models;

class BatchCreateCustomersParamsCustomersItemAddress
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
