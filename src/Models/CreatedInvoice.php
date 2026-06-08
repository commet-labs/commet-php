<?php

declare(strict_types=1);

namespace Commet\Models;

use Commet\Enums\InvoiceType;

class CreatedInvoice
{
    public function __construct(
        public readonly string $id,
        public readonly string $customerId,
        public readonly string $invoiceNumber,
        public readonly string $status,
        public readonly InvoiceType $invoiceType,
        public readonly string $currency,
        public readonly int $subtotal,
        public readonly int $taxAmount,
        public readonly int $total,
        public readonly string $issueDate,
        public readonly string $dueDate,
        /** @var array<string, mixed> */
        public readonly array $metadata,
        public readonly string $createdAt,
        public readonly string $updatedAt,
        public readonly string $object,
        public readonly bool $livemode,
        public readonly ?string $memo = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data["id"],
            customerId: $data["customer_id"],
            invoiceNumber: $data["invoice_number"],
            status: $data["status"],
            invoiceType: InvoiceType::from($data["invoice_type"]),
            currency: $data["currency"],
            subtotal: $data["subtotal"],
            taxAmount: $data["tax_amount"],
            total: $data["total"],
            issueDate: $data["issue_date"],
            dueDate: $data["due_date"],
            metadata: $data["metadata"],
            createdAt: $data["created_at"],
            updatedAt: $data["updated_at"],
            object: $data["object"],
            livemode: $data["livemode"],
            memo: $data["memo"] ?? null,
        );
    }
}
