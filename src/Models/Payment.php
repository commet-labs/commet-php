<?php

declare(strict_types=1);

namespace Commet\Models;

use Commet\Enums\PaymentProvider;

class Payment
{
    public function __construct(
        public readonly string $id,
        public readonly string $kind,
        public readonly string $status,
        public readonly PaymentProvider $provider,
        public readonly int $amountSubtotal,
        public readonly int $taxAmount,
        public readonly int $amountTotal,
        public readonly string $currency,
        public readonly string $description,
        public readonly string $createdAt,
        public readonly string $updatedAt,
        public readonly string $object,
        public readonly bool $livemode,
        public readonly ?string $customerId = null,
        /** @var array<string, mixed>|null */
        public readonly ?array $metadata = null,
        public readonly ?string $url = null,
        public readonly ?string $expiresAt = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data["id"],
            kind: $data["kind"],
            status: $data["status"],
            provider: PaymentProvider::from($data["provider"]),
            amountSubtotal: $data["amount_subtotal"],
            taxAmount: $data["tax_amount"],
            amountTotal: $data["amount_total"],
            currency: $data["currency"],
            description: $data["description"],
            createdAt: $data["created_at"],
            updatedAt: $data["updated_at"],
            object: $data["object"],
            livemode: $data["livemode"],
            customerId: $data["customer_id"] ?? null,
            metadata: $data["metadata"] ?? null,
            url: $data["url"] ?? null,
            expiresAt: $data["expires_at"] ?? null,
        );
    }
}
