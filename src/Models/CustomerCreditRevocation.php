<?php

declare(strict_types=1);

namespace Commet\Models;

class CustomerCreditRevocation
{
    public function __construct(
        public readonly string $id,
        public readonly int $remainingAmount,
        public readonly int $revokedAmount,
        public readonly string $currency,
        public readonly string $object,
        public readonly bool $livemode,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data["id"],
            remainingAmount: $data["remaining_amount"],
            revokedAmount: $data["revoked_amount"],
            currency: $data["currency"],
            object: $data["object"],
            livemode: $data["livemode"],
        );
    }
}
