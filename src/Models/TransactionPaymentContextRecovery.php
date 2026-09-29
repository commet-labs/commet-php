<?php

declare(strict_types=1);

namespace Commet\Models;

abstract class TransactionPaymentContextRecovery
{
    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return match ($data["type"] ?? null) {
            "payment_recovery" => TransactionPaymentContextRecoveryVariant1::fromArray($data),
            "dunning_retry" => TransactionPaymentContextRecoveryVariant2::fromArray($data),
            default => TransactionPaymentContextRecoveryVariant1::fromArray($data),
        };
    }
}
