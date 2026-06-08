<?php

declare(strict_types=1);

namespace Commet\Models;

class InvoiceStatus
{
    public function __construct(
        public readonly string $id,
        public readonly string $status,
        public readonly string $updatedAt,
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
            status: $data["status"],
            updatedAt: $data["updated_at"],
            object: $data["object"],
            livemode: $data["livemode"],
        );
    }
}
