<?php

declare(strict_types=1);

namespace Commet\Models;

class DeletedSubscriptionAddon
{
    public function __construct(
        public readonly string $id,
        public readonly string $status,
        public readonly string $object,
        public readonly bool $livemode,
        public readonly ?string $deactivatedAt = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data["id"],
            status: $data["status"],
            object: $data["object"],
            livemode: $data["livemode"],
            deactivatedAt: $data["deactivated_at"] ?? null,
        );
    }
}
