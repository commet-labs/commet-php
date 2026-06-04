<?php

declare(strict_types=1);

namespace Commet\Models;

use Commet\Enums\InvoiceStatus;

class InvoiceStatusResult
{
    public function __construct(
        public readonly string $id,
        public readonly InvoiceStatus $status,
        public readonly string $updatedAt,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            status: InvoiceStatus::from($data['status']),
            updatedAt: $data['updated_at'],
        );
    }
}
