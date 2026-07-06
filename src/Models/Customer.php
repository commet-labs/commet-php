<?php

declare(strict_types=1);

namespace Commet\Models;

class Customer
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
