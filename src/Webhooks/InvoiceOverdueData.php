<?php

declare(strict_types=1);

namespace Commet\Webhooks;

/** Fired once when an outstanding invoice passes its due date without payment. The invoice keeps its outstanding status — overdue is a fact about the due date, not a new status. Use it to start your own dunning flow. */
final class InvoiceOverdueData
{
    public function __construct(
        public readonly string $invoiceId,
        public readonly string $invoiceNumber,
        public readonly string $invoiceStatus,
        public readonly ?string $periodStart,
        public readonly ?string $periodEnd,
        public readonly ?string $issueDate,
        public readonly string $dueDate,
        public readonly string $currency,
        public readonly float $subtotal,
        public readonly float $total,
        public readonly string $customerId,
        public readonly ?string $subscriptionId,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            invoiceId: $data["invoiceId"],
            invoiceNumber: $data["invoiceNumber"],
            invoiceStatus: $data["invoiceStatus"],
            periodStart: $data["periodStart"] ?? null,
            periodEnd: $data["periodEnd"] ?? null,
            issueDate: $data["issueDate"] ?? null,
            dueDate: $data["dueDate"],
            currency: $data["currency"],
            subtotal: $data["subtotal"],
            total: $data["total"],
            customerId: $data["customerId"],
            subscriptionId: $data["subscriptionId"] ?? null,
        );
    }
}
