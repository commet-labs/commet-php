<?php

declare(strict_types=1);

namespace Commet\Webhooks;

final class WebhookBankRef
{
    public function __construct(
        public readonly string $bankName,
        public readonly string $last4,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            bankName: $data["bankName"],
            last4: $data["last4"],
        );
    }
}
