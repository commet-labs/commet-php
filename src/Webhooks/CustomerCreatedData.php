<?php

declare(strict_types=1);

namespace Commet\Webhooks;

/** Fired when a customer is created, via the API (including batch create), SDK, or dashboard. The payload is the customer resource exactly as GET /customers returns it. */
final class CustomerCreatedData
{
    public function __construct(
        public readonly string $id,
        public readonly ?string $externalId,
        public readonly ?string $fullName,
        public readonly string $email,
        public readonly ?string $timezone,
        /** @var array<string, mixed> */
        public readonly ?array $metadata,
        public readonly string $createdAt,
        public readonly string $updatedAt,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data["id"],
            externalId: $data["externalId"] ?? null,
            fullName: $data["fullName"] ?? null,
            email: $data["email"],
            timezone: $data["timezone"] ?? null,
            metadata: $data["metadata"] ?? null,
            createdAt: $data["createdAt"],
            updatedAt: $data["updatedAt"],
        );
    }
}
