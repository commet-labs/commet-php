<?php

declare(strict_types=1);

namespace Commet\Models;

class Customer implements \JsonSerializable
{
    public function __construct(
        public readonly string $id,
        public readonly string $email,
        public readonly string $createdAt,
        public readonly string $updatedAt,
        public readonly string $object,
        public readonly bool $livemode,
        public readonly ?string $externalId = null,
        public readonly ?string $fullName = null,
        public readonly ?string $taxDocument = null,
        public readonly ?string $documentType = null,
        public readonly ?string $timezone = null,
        /** @var array<string, mixed>|null */
        public readonly ?array $metadata = null,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["id"] = $this->id;
        $values["externalId"] = $this->externalId;
        $values["fullName"] = $this->fullName;
        $values["email"] = $this->email;
        $values["taxDocument"] = $this->taxDocument;
        $values["documentType"] = $this->documentType;
        $values["timezone"] = $this->timezone;
        $values["metadata"] = $this->metadata;
        $values["createdAt"] = $this->createdAt;
        $values["updatedAt"] = $this->updatedAt;
        $values["object"] = $this->object;
        $values["livemode"] = $this->livemode;
        return (object) $values;
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data["id"],
            email: $data["email"],
            createdAt: $data["created_at"],
            updatedAt: $data["updated_at"],
            object: $data["object"],
            livemode: $data["livemode"],
            externalId: $data["external_id"] ?? null,
            fullName: $data["full_name"] ?? null,
            taxDocument: $data["tax_document"] ?? null,
            documentType: $data["document_type"] ?? null,
            timezone: $data["timezone"] ?? null,
            metadata: $data["metadata"] ?? null,
        );
    }
}
