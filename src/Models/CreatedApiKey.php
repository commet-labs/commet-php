<?php

declare(strict_types=1);

namespace Commet\Models;

class CreatedApiKey
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly string $apiKey,
        public readonly string $prefix,
        public readonly string $expiresAt,
        public readonly string $createdAt,
        public readonly string $object,
        public readonly bool $livemode,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data["id"],
            name: $data["name"],
            apiKey: $data["api_key"],
            prefix: $data["prefix"],
            expiresAt: $data["expires_at"],
            createdAt: $data["created_at"],
            object: $data["object"],
            livemode: $data["livemode"],
        );
    }
}
