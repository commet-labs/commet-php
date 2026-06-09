<?php

declare(strict_types=1);

namespace Commet\Models;

class PayoutVerification
{
    public function __construct(
        public readonly string $providerAccountId,
        public readonly string $status,
        public readonly bool $transfersEnabled,
        public readonly string $object,
        public readonly bool $livemode,
        public readonly ?bool $alreadyExists = null,
        public readonly ?string $businessType = null,
        public readonly ?string $country = null,
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
            object: $data["object"],
            livemode: $data["livemode"],
            alreadyExists: $data["already_exists"] ?? null,
            businessType: $data["business_type"] ?? null,
            country: $data["country"] ?? null,
        );
    }
}
