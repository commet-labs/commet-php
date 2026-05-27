<?php

declare(strict_types=1);

namespace Commet\Models;

class Invoice
{
    /**
     * @param array<string, mixed>|null $metadata
     * @param InvoiceLineItem[] $lineItems
     */
    public function __construct(
        public readonly string $id,
        public readonly string $object,
        public readonly bool $livemode,
        public readonly string $customerId,
        public readonly string $invoiceNumber,
        public readonly string $status,
        public readonly string $invoiceType,
        public readonly string $currency,
        public readonly int $subtotal,
        public readonly int $discountAmount,
        public readonly int $taxAmount,
        public readonly int $total,
        public readonly string $issueDate,
        public readonly string $createdAt,
        public readonly string $updatedAt,
        public readonly ?string $subscriptionId = null,
        public readonly ?string $periodStart = null,
        public readonly ?string $periodEnd = null,
        public readonly ?string $dueDate = null,
        public readonly ?string $memo = null,
        public readonly ?array $metadata = null,
        public readonly ?int $creditApplied = null,
        public readonly ?string $planName = null,
        public readonly ?string $poNumber = null,
        public readonly ?string $reference = null,
        public readonly array $lineItems = [],
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        $lineItems = array_map(
            fn(array $item) => InvoiceLineItem::fromArray($item),
            $data['line_items'] ?? [],
        );

        return new self(
            id: $data['id'],
            object: $data['object'] ?? 'invoice',
            livemode: $data['livemode'] ?? false,
            customerId: $data['customer_id'],
            invoiceNumber: $data['invoice_number'],
            status: $data['status'],
            invoiceType: $data['invoice_type'],
            currency: $data['currency'],
            subtotal: $data['subtotal'],
            discountAmount: $data['discount_amount'] ?? 0,
            taxAmount: $data['tax_amount'],
            total: $data['total'],
            issueDate: $data['issue_date'],
            createdAt: $data['created_at'],
            updatedAt: $data['updated_at'],
            subscriptionId: $data['subscription_id'] ?? null,
            periodStart: $data['period_start'] ?? null,
            periodEnd: $data['period_end'] ?? null,
            dueDate: $data['due_date'] ?? null,
            memo: $data['memo'] ?? null,
            metadata: $data['metadata'] ?? null,
            creditApplied: $data['credit_applied'] ?? null,
            planName: $data['plan_name'] ?? null,
            poNumber: $data['po_number'] ?? null,
            reference: $data['reference'] ?? null,
            lineItems: $lineItems,
        );
    }
}
