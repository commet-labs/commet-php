<?php

declare(strict_types=1);

namespace Commet\Models;

class ApiKey
{
    public function __construct(
        public readonly string $id,
        public readonly string $object,
        public readonly bool $livemode,
        public readonly string $name,
        public readonly string $prefix,
        public readonly string $createdAt,
        public readonly ?string $expiresAt = null,
        public readonly ?string $lastUsedAt = null,
        public readonly ?string $apiKey = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            object: $data['object'] ?? 'api_key',
            livemode: $data['livemode'] ?? false,
            name: $data['name'],
            prefix: $data['prefix'],
            createdAt: $data['created_at'],
            expiresAt: $data['expires_at'] ?? null,
            lastUsedAt: $data['last_used_at'] ?? null,
            apiKey: $data['api_key'] ?? null,
        );
    }
}
