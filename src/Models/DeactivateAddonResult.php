<?php

declare(strict_types=1);

namespace Commet\Models;

class DeactivateAddonResult
{
    public function __construct(
        public readonly string $id,
        public readonly string $status,
        public readonly string $deactivatedAt,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            status: $data['status'],
            deactivatedAt: $data['deactivated_at'],
        );
    }
}
