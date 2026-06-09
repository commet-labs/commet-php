<?php

declare(strict_types=1);

namespace Commet\Models;

use Commet\Enums\TransactionStatus;

class Transaction
{
    public function __construct(
        public readonly string $id,
        public readonly int $grossAmount,
        public readonly int $subtotal,
        public readonly int $taxAmount,
        public readonly string $currency,
        public readonly TransactionStatus $status,
        public readonly string $createdAt,
        public readonly string $updatedAt,
        public readonly string $object,
        public readonly bool $livemode,
        public readonly ?string $invoiceId = null,
        public readonly ?string $customerEmail = null,
        public readonly ?string $customerName = null,
        public readonly ?string $paidAt = null,
        public readonly ?string $availableAt = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data["id"],
            grossAmount: $data["gross_amount"],
            subtotal: $data["subtotal"],
            taxAmount: $data["tax_amount"],
            currency: $data["currency"],
            status: TransactionStatus::from($data["status"]),
            createdAt: $data["created_at"],
            updatedAt: $data["updated_at"],
            object: $data["object"],
            livemode: $data["livemode"],
            invoiceId: $data["invoice_id"] ?? null,
            customerEmail: $data["customer_email"] ?? null,
            customerName: $data["customer_name"] ?? null,
            paidAt: $data["paid_at"] ?? null,
            availableAt: $data["available_at"] ?? null,
        );
    }
}
