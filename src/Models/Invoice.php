<?php

declare(strict_types=1);

namespace Commet\Models;

use Commet\Enums\InvoiceType;

class Invoice implements \JsonSerializable
{
    public function __construct(
        public readonly string $id,
        public readonly string $customerId,
        public readonly string $invoiceNumber,
        public readonly string $status,
        public readonly InvoiceType $invoiceType,
        public readonly string $currency,
        public readonly int $subtotal,
        public readonly int $discountAmount,
        public readonly int $taxAmount,
        public readonly int $total,
        public readonly string $periodStart,
        public readonly string $periodEnd,
        public readonly string $issueDate,
        public readonly string $dueDate,
        /** @var array<string, mixed> */
        public readonly array $metadata,
        public readonly string $createdAt,
        public readonly string $updatedAt,
        public readonly int $creditApplied,
        /** @var InvoiceLineItemsItem[] */
        public readonly array $lineItems,
        public readonly string $object,
        public readonly bool $livemode,
        public readonly ?string $subscriptionId = null,
        public readonly ?string $memo = null,
        public readonly ?string $planName = null,
        public readonly ?string $poNumber = null,
        public readonly ?string $reference = null,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["id"] = $this->id;
        $values["customerId"] = $this->customerId;
        $values["subscriptionId"] = $this->subscriptionId;
        $values["invoiceNumber"] = $this->invoiceNumber;
        $values["status"] = $this->status;
        $values["invoiceType"] = $this->invoiceType;
        $values["currency"] = $this->currency;
        $values["subtotal"] = $this->subtotal;
        $values["discountAmount"] = $this->discountAmount;
        $values["taxAmount"] = $this->taxAmount;
        $values["total"] = $this->total;
        $values["periodStart"] = $this->periodStart;
        $values["periodEnd"] = $this->periodEnd;
        $values["issueDate"] = $this->issueDate;
        $values["dueDate"] = $this->dueDate;
        $values["memo"] = $this->memo;
        $values["metadata"] = $this->metadata;
        $values["createdAt"] = $this->createdAt;
        $values["updatedAt"] = $this->updatedAt;
        $values["creditApplied"] = $this->creditApplied;
        $values["planName"] = $this->planName;
        $values["poNumber"] = $this->poNumber;
        $values["reference"] = $this->reference;
        $values["lineItems"] = $this->lineItems;
        $values["object"] = $this->object;
        $values["livemode"] = $this->livemode;
        return (object) $values;
    }

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
            discountAmount: $data["discount_amount"],
            taxAmount: $data["tax_amount"],
            total: $data["total"],
            periodStart: $data["period_start"],
            periodEnd: $data["period_end"],
            issueDate: $data["issue_date"],
            dueDate: $data["due_date"],
            metadata: $data["metadata"],
            createdAt: $data["created_at"],
            updatedAt: $data["updated_at"],
            creditApplied: $data["credit_applied"],
            lineItems: array_map(fn(array $item) => InvoiceLineItemsItem::fromArray($item), $data["line_items"]),
            object: $data["object"],
            livemode: $data["livemode"],
            subscriptionId: $data["subscription_id"] ?? null,
            memo: $data["memo"] ?? null,
            planName: $data["plan_name"] ?? null,
            poNumber: $data["po_number"] ?? null,
            reference: $data["reference"] ?? null,
        );
    }
}
