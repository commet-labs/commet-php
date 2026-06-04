<?php

declare(strict_types=1);

namespace Commet\Models;

use Commet\Enums\TransactionStatus;

class TransactionRefundResult
{
    public function __construct(
        public readonly string $id,
        public readonly TransactionStatus $status,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            status: TransactionStatus::from($data['status']),
        );
    }
}
