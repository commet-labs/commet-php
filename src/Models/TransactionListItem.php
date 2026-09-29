<?php

declare(strict_types=1);

namespace Commet\Models;

use Commet\Enums\PaymentMethod;
use Commet\Enums\PaymentProvider;
use Commet\Enums\SubPaymentMethod;
use Commet\Enums\TransactionStatus;

class TransactionListItem implements \JsonSerializable
{
    public function __construct(
        public readonly string $id,
        public readonly string $currency,
        public readonly PaymentProvider $provider,
        public readonly TransactionStatus $status,
        public readonly string $createdAt,
        public readonly string $updatedAt,
        public readonly string $object,
        public readonly bool $livemode,
        public readonly ?TransactionListItemPaymentContext $paymentContext = null,
        public readonly ?string $invoiceId = null,
        public readonly ?int $grossAmount = null,
        public readonly ?int $subtotal = null,
        public readonly ?int $taxAmount = null,
        public readonly ?int $presentmentAmount = null,
        public readonly ?PaymentMethod $paymentMethod = null,
        public readonly ?SubPaymentMethod $subPaymentMethod = null,
        public readonly ?string $customerEmail = null,
        public readonly ?string $customerName = null,
        public readonly ?string $paidAt = null,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["paymentContext"] = $this->paymentContext;
        $values["id"] = $this->id;
        $values["invoiceId"] = $this->invoiceId;
        $values["grossAmount"] = $this->grossAmount;
        $values["subtotal"] = $this->subtotal;
        $values["taxAmount"] = $this->taxAmount;
        $values["presentmentAmount"] = $this->presentmentAmount;
        $values["currency"] = $this->currency;
        $values["provider"] = $this->provider;
        $values["paymentMethod"] = $this->paymentMethod;
        $values["subPaymentMethod"] = $this->subPaymentMethod;
        $values["status"] = $this->status;
        $values["customerEmail"] = $this->customerEmail;
        $values["customerName"] = $this->customerName;
        $values["paidAt"] = $this->paidAt;
        $values["createdAt"] = $this->createdAt;
        $values["updatedAt"] = $this->updatedAt;
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
            currency: $data["currency"],
            provider: PaymentProvider::from($data["provider"]),
            status: TransactionStatus::from($data["status"]),
            createdAt: $data["created_at"],
            updatedAt: $data["updated_at"],
            object: $data["object"],
            livemode: $data["livemode"],
            paymentContext: isset($data["payment_context"]) ? TransactionListItemPaymentContext::fromArray($data["payment_context"]) : null,
            invoiceId: $data["invoice_id"] ?? null,
            grossAmount: $data["gross_amount"] ?? null,
            subtotal: $data["subtotal"] ?? null,
            taxAmount: $data["tax_amount"] ?? null,
            presentmentAmount: $data["presentment_amount"] ?? null,
            paymentMethod: isset($data["payment_method"]) ? PaymentMethod::from($data["payment_method"]) : null,
            subPaymentMethod: isset($data["sub_payment_method"]) ? SubPaymentMethod::from($data["sub_payment_method"]) : null,
            customerEmail: $data["customer_email"] ?? null,
            customerName: $data["customer_name"] ?? null,
            paidAt: $data["paid_at"] ?? null,
        );
    }
}
