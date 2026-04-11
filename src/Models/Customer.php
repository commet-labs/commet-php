<?php

declare(strict_types=1);

namespace Commet\Models;

class Customer
{
    public function __construct(
        public readonly string $id,
        public readonly string $organizationId,
        public readonly string $billingEmail,
        public readonly bool $isActive,
        public readonly string $createdAt,
        public readonly string $updatedAt,
        public readonly ?string $externalId = null,
        public readonly ?string $fullName = null,
        public readonly ?string $domain = null,
        public readonly ?string $website = null,
        public readonly ?string $timezone = null,
        public readonly ?string $language = null,
        public readonly ?string $industry = null,
        public readonly ?string $employeeCount = null,
        /** @var array<string, mixed>|null */
        public readonly ?array $metadata = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            organizationId: $data['organization_id'],
            billingEmail: $data['billing_email'],
            isActive: $data['is_active'],
            createdAt: $data['created_at'],
            updatedAt: $data['updated_at'],
            externalId: $data['external_id'] ?? null,
            fullName: $data['full_name'] ?? null,
            domain: $data['domain'] ?? null,
            website: $data['website'] ?? null,
            timezone: $data['timezone'] ?? null,
            language: $data['language'] ?? null,
            industry: $data['industry'] ?? null,
            employeeCount: $data['employee_count'] ?? null,
            metadata: $data['metadata'] ?? null,
        );
    }
}
