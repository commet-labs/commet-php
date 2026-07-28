<?php

declare(strict_types=1);

namespace Commet\Models;

use Commet\Enums\Timezone;

class BatchCreateCustomersParamsCustomersItem
{
    public function __construct(
        public readonly string $email,
        public readonly ?string $id = null,
        public readonly ?string $externalId = null,
        public readonly ?string $fullName = null,
        public readonly ?string $taxDocument = null,
        public readonly ?Timezone $timezone = null,
        /** @var array<string, mixed>|null */
        public readonly ?array $metadata = null,
        public readonly ?BatchCreateCustomersParamsCustomersItemAddress $address = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            email: $data["email"],
            id: $data["id"] ?? null,
            externalId: $data["external_id"] ?? null,
            fullName: $data["full_name"] ?? null,
            taxDocument: $data["tax_document"] ?? null,
            timezone: isset($data["timezone"]) ? Timezone::from($data["timezone"]) : null,
            metadata: $data["metadata"] ?? null,
            address: isset($data["address"]) ? BatchCreateCustomersParamsCustomersItemAddress::fromArray($data["address"]) : null,
        );
    }
}
