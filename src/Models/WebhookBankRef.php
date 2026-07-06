<?php

declare(strict_types=1);

namespace Commet\Models;

class WebhookBankRef
{
    public function __construct(
        public readonly string $last4,
        public readonly ?string $bankName = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            last4: $data["last4"],
            bankName: $data["bank_name"] ?? null,
        );
    }
}
