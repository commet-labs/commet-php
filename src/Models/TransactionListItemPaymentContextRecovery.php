<?php

declare(strict_types=1);

namespace Commet\Models;

abstract class TransactionListItemPaymentContextRecovery
{
    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return match ($data["type"] ?? null) {
            "payment_recovery" => TransactionListItemPaymentContextRecoveryVariant1::fromArray($data),
            "dunning_retry" => TransactionListItemPaymentContextRecoveryVariant2::fromArray($data),
            default => TransactionListItemPaymentContextRecoveryVariant1::fromArray($data),
        };
    }
}
