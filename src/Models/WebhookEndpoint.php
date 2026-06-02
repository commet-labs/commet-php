<?php

declare(strict_types=1);

namespace Commet\Models;

class WebhookEndpoint
{
    /**
     * @param string[] $events
     */
    public function __construct(
        public readonly string $id,
        public readonly string $object,
        public readonly bool $livemode,
        public readonly string $url,
        public readonly array $events,
        public readonly bool $isActive,
        public readonly string $createdAt,
        public readonly ?string $description = null,
        public readonly ?string $apiVersion = null,
        public readonly ?string $secretKey = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            object: $data['object'] ?? 'webhook_endpoint',
            livemode: $data['livemode'] ?? false,
            url: $data['url'],
            events: $data['events'],
            isActive: $data['is_active'],
            createdAt: $data['created_at'],
            description: $data['description'] ?? null,
            apiVersion: $data['api_version'] ?? null,
            secretKey: $data['secret_key'] ?? null,
        );
    }
}
