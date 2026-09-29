<?php

declare(strict_types=1);

namespace Commet\Models;

class TestClockLatestRunItemsItem implements \JsonSerializable
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

    public function jsonSerialize(): object
    {
        $values = [];
        $values["kind"] = $this->kind;
        $values["status"] = $this->status;
        $values["dueAt"] = $this->dueAt;
        $values["subscriptionId"] = $this->subscriptionId;
        $values["customerName"] = $this->customerName;
        $values["invoiceNumber"] = $this->invoiceNumber;
        $values["invoiceId"] = $this->invoiceId;
        $values["outcome"] = $this->outcome;
        $values["detail"] = $this->detail;
        $values["error"] = $this->error;
        return (object) $values;
    }

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
