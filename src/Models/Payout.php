<?php

declare(strict_types=1);

namespace Commet\Models;

class Payout
{
    public function __construct(
        public readonly string $id,
        public readonly string $status,
        public readonly int $amount,
        public readonly int $fee,
        public readonly int $netAmount,
        public readonly string $currency,
        public readonly string $providerTransferId,
        public readonly string $createdAt,
        public readonly string $object,
        public readonly bool $livemode,
        public readonly ?string $description = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data["id"],
            status: $data["status"],
            amount: $data["amount"],
            fee: $data["fee"],
            netAmount: $data["net_amount"],
            currency: $data["currency"],
            providerTransferId: $data["provider_transfer_id"],
            createdAt: $data["created_at"],
            object: $data["object"],
            livemode: $data["livemode"],
            description: $data["description"] ?? null,
        );
    }
}
