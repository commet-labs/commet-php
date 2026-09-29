<?php

declare(strict_types=1);

namespace Commet\Models;

use Commet\Enums\Timezone;

class BatchCreateCustomersParamsCustomersItem implements \JsonSerializable
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

    public function jsonSerialize(): object
    {
        $values = [];
        $values["email"] = $this->email;
        if ($this->id !== null) {
            $values["id"] = $this->id;
        }
        if ($this->externalId !== null) {
            $values["externalId"] = $this->externalId;
        }
        if ($this->fullName !== null) {
            $values["fullName"] = $this->fullName;
        }
        if ($this->taxDocument !== null) {
            $values["taxDocument"] = $this->taxDocument;
        }
        if ($this->timezone !== null) {
            $values["timezone"] = $this->timezone;
        }
        if ($this->metadata !== null) {
            $values["metadata"] = $this->metadata;
        }
        if ($this->address !== null) {
            $values["address"] = $this->address;
        }
        return (object) $values;
    }

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
