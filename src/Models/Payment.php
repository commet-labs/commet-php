<?php

declare(strict_types=1);

namespace Commet\Models;

class Payment implements \JsonSerializable
{
    public function __construct(
        public readonly string $id,
        public readonly string $kind,
        public readonly string $status,
        public readonly string $provider,
        public readonly int $amountSubtotal,
        public readonly int $taxAmount,
        public readonly int $amountTotal,
        public readonly string $currency,
        public readonly string $description,
        public readonly string $createdAt,
        public readonly string $updatedAt,
        public readonly string $object,
        public readonly bool $livemode,
        public readonly ?PaymentPaymentContext $paymentContext = null,
        public readonly ?string $customerId = null,
        /** @var array<string, mixed>|null */
        public readonly ?array $metadata = null,
        public readonly ?string $url = null,
        public readonly ?string $expiresAt = null,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["paymentContext"] = $this->paymentContext;
        $values["id"] = $this->id;
        $values["customerId"] = $this->customerId;
        $values["kind"] = $this->kind;
        $values["status"] = $this->status;
        $values["provider"] = $this->provider;
        $values["amountSubtotal"] = $this->amountSubtotal;
        $values["taxAmount"] = $this->taxAmount;
        $values["amountTotal"] = $this->amountTotal;
        $values["currency"] = $this->currency;
        $values["description"] = $this->description;
        $values["metadata"] = $this->metadata;
        $values["url"] = $this->url;
        $values["expiresAt"] = $this->expiresAt;
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
            kind: $data["kind"],
            status: $data["status"],
            provider: $data["provider"],
            amountSubtotal: $data["amount_subtotal"],
            taxAmount: $data["tax_amount"],
            amountTotal: $data["amount_total"],
            currency: $data["currency"],
            description: $data["description"],
            createdAt: $data["created_at"],
            updatedAt: $data["updated_at"],
            object: $data["object"],
            livemode: $data["livemode"],
            paymentContext: isset($data["payment_context"]) ? PaymentPaymentContext::fromArray($data["payment_context"]) : null,
            customerId: $data["customer_id"] ?? null,
            metadata: $data["metadata"] ?? null,
            url: $data["url"] ?? null,
            expiresAt: $data["expires_at"] ?? null,
        );
    }
}
