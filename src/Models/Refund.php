<?php

declare(strict_types=1);

namespace Commet\Models;

class Refund
{
    public function __construct(
        public readonly string $id,
        public readonly string $transactionId,
        public readonly int $amount,
        public readonly string $currency,
        public readonly string $status,
        public readonly string $object,
        public readonly bool $livemode,
        public readonly ?string $chargeId = null,
        public readonly ?string $reason = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data["id"],
            transactionId: $data["transaction_id"],
            amount: $data["amount"],
            currency: $data["currency"],
            status: $data["status"],
            object: $data["object"],
            livemode: $data["livemode"],
            chargeId: $data["charge_id"] ?? null,
            reason: $data["reason"] ?? null,
        );
    }
}
