<?php

declare(strict_types=1);

namespace Commet\Models;

class CompletePayoutVerificationParamsBank
{
    public function __construct(
        public readonly string $accountNumber,
        public readonly string $accountHolderName,
        public readonly ?string $routingNumber = null,
        public readonly ?string $accountType = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            accountNumber: $data["account_number"],
            accountHolderName: $data["account_holder_name"],
            routingNumber: $data["routing_number"] ?? null,
            accountType: $data["account_type"] ?? null,
        );
    }
}
