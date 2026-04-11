<?php

declare(strict_types=1);

namespace Commet\Models;

class UsageEvent
{
    /**
     * @param UsageEventProperty[] $properties
     */
    public function __construct(
        public readonly string $id,
        public readonly string $organizationId,
        public readonly string $customerId,
        public readonly string $feature,
        public readonly string $ts,
        public readonly string $createdAt,
        public readonly ?string $idempotencyKey = null,
        public readonly array $properties = [],
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        $properties = array_map(
            fn(array $prop) => UsageEventProperty::fromArray($prop),
            $data['properties'] ?? [],
        );

        return new self(
            id: $data['id'],
            organizationId: $data['organization_id'],
            customerId: $data['customer_id'],
            feature: $data['feature'],
            ts: $data['ts'],
            createdAt: $data['created_at'],
            idempotencyKey: $data['idempotency_key'] ?? null,
            properties: $properties,
        );
    }
}
