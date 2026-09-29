<?php

declare(strict_types=1);

namespace Commet\Models;

abstract class PaymentPaymentContextRecovery
{
    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return match ($data["type"] ?? null) {
            "payment_recovery" => PaymentPaymentContextRecoveryVariant1::fromArray($data),
            "dunning_retry" => PaymentPaymentContextRecoveryVariant2::fromArray($data),
            default => PaymentPaymentContextRecoveryVariant1::fromArray($data),
        };
    }
}
