<?php

declare(strict_types=1);

namespace Commet\Webhooks;

/** Organization-level event about YOUR money as the merchant. Fired when payment funds the provider was holding become available to pay out to your bank. */
final class PayoutAvailableData
{
    public function __construct(
        public readonly float $availableAmount,
        public readonly string $currency,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            availableAmount: $data["availableAmount"],
            currency: $data["currency"],
        );
    }
}
