<?php

declare(strict_types=1);

namespace Commet\Models;

class TestClockRunItemsItem
{
    public function __construct(
        public readonly string $kind,
        public readonly string $status,
        public readonly string $dueAt,
        public readonly string $subscriptionId,
        public readonly ?string $customerName = null,
        public readonly ?string $invoiceNumber = null,
        public readonly ?string $invoiceId = null,
        public readonly ?string $outcome = null,
        public readonly ?string $detail = null,
        public readonly ?string $error = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            kind: $data["kind"],
            status: $data["status"],
            dueAt: $data["due_at"],
            subscriptionId: $data["subscription_id"],
            customerName: $data["customer_name"] ?? null,
            invoiceNumber: $data["invoice_number"] ?? null,
            invoiceId: $data["invoice_id"] ?? null,
            outcome: $data["outcome"] ?? null,
            detail: $data["detail"] ?? null,
            error: $data["error"] ?? null,
        );
    }
}
