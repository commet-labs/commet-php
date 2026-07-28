<?php

declare(strict_types=1);

namespace Commet\Models;

class PayoutVerificationVariant1 extends PayoutVerification
{
    public function __construct(
        public readonly string $providerAccountId,
        public readonly string $status,
        public readonly bool $transfersEnabled,
        public readonly string $outcome,
        public readonly string $object,
        public readonly bool $livemode,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            providerAccountId: $data["provider_account_id"],
            status: $data["status"],
            transfersEnabled: $data["transfers_enabled"],
            outcome: $data["outcome"],
            object: $data["object"],
            livemode: $data["livemode"],
        );
    }
}
