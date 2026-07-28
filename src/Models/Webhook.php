<?php

declare(strict_types=1);

namespace Commet\Models;

class Webhook
{
    public function __construct(
        public readonly string $id,
        public readonly string $url,
        /** @var string[] */
        public readonly array $events,
        public readonly bool $isActive,
        public readonly string $createdAt,
        public readonly string $object,
        public readonly bool $livemode,
        public readonly ?string $description = null,
        public readonly ?string $apiVersion = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data["id"],
            url: $data["url"],
            events: $data["events"],
            isActive: $data["is_active"],
            createdAt: $data["created_at"],
            object: $data["object"],
            livemode: $data["livemode"],
            description: $data["description"] ?? null,
            apiVersion: $data["api_version"] ?? null,
        );
    }
}
