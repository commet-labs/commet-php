<?php

declare(strict_types=1);

namespace Commet\Models;

class TransactionRetry
{
    public function __construct(
        public readonly string $originalTransactionId,
        public readonly string $invoiceId,
        public readonly string $status,
        public readonly string $object,
        public readonly bool $livemode,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            originalTransactionId: $data["original_transaction_id"],
            invoiceId: $data["invoice_id"],
            status: $data["status"],
            object: $data["object"],
            livemode: $data["livemode"],
        );
    }
}
