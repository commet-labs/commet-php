<?php

declare(strict_types=1);

namespace Commet\Models;

class TransactionRetryResult
{
    /**
     * The retry response status is the synthetic literal `'processing'`, which is
     * not a member of {@see \Commet\Enums\TransactionStatus}, so it stays typed
     * as a plain string.
     */
    public function __construct(
        public readonly string $id,
        public readonly string $status,
        public readonly string $retryInvoiceNumber,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            status: $data['status'],
            retryInvoiceNumber: $data['retry_invoice_number'],
        );
    }
}
