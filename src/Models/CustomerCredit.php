<?php

declare(strict_types=1);

namespace Commet\Models;

class CustomerCredit
{
    public function __construct(
        public readonly string $id,
        public readonly int $amount,
        public readonly int $appliedAmount,
        public readonly int $reversedAmount,
        public readonly int $revokedAmount,
        public readonly int $remainingAmount,
        public readonly string $currency,
        public readonly string $reason,
        public readonly string $source,
        public readonly string $createdAt,
        public readonly string $object,
        public readonly bool $livemode,
        public readonly ?string $expiresAt = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data["id"],
            amount: $data["amount"],
            appliedAmount: $data["applied_amount"],
            reversedAmount: $data["reversed_amount"],
            revokedAmount: $data["revoked_amount"],
            remainingAmount: $data["remaining_amount"],
            currency: $data["currency"],
            reason: $data["reason"],
            source: $data["source"],
            createdAt: $data["created_at"],
            object: $data["object"],
            livemode: $data["livemode"],
            expiresAt: $data["expires_at"] ?? null,
        );
    }
}
