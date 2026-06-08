<?php

declare(strict_types=1);

namespace Commet\Models;

class PayoutBankAccount
{
    public function __construct(
        public readonly string $id,
        public readonly string $holderName,
        public readonly string $last4,
        public readonly string $country,
        public readonly string $currency,
        public readonly bool $isDefault,
        public readonly string $status,
        public readonly string $createdAt,
        public readonly string $object,
        public readonly bool $livemode,
        public readonly ?string $providerExternalAccountId = null,
        public readonly ?string $bankName = null,
        public readonly ?string $accountType = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data["id"],
            holderName: $data["holder_name"],
            last4: $data["last4"],
            country: $data["country"],
            currency: $data["currency"],
            isDefault: $data["is_default"],
            status: $data["status"],
            createdAt: $data["created_at"],
            object: $data["object"],
            livemode: $data["livemode"],
            providerExternalAccountId: $data["provider_external_account_id"] ?? null,
            bankName: $data["bank_name"] ?? null,
            accountType: $data["account_type"] ?? null,
        );
    }
}
