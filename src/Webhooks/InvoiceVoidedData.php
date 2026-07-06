<?php

declare(strict_types=1);

namespace Commet\Webhooks;

/** Fired when an invoice is voided — nullified before collection, either manually or automatically when its subscription is canceled. Voiding is terminal: a void invoice is never retried or collected. */
final class InvoiceVoidedData
{
    public function __construct(
        public readonly string $invoiceId,
        public readonly string $invoiceNumber,
        public readonly string $invoiceStatus,
        public readonly string $periodStart,
        public readonly string $periodEnd,
        public readonly string $issueDate,
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
            periodStart: $data["periodStart"],
            periodEnd: $data["periodEnd"],
            issueDate: $data["issueDate"],
            dueDate: $data["dueDate"],
            currency: $data["currency"],
            subtotal: $data["subtotal"],
            total: $data["total"],
            customerId: $data["customerId"],
            subscriptionId: $data["subscriptionId"] ?? null,
        );
    }
}
