<?php

declare(strict_types=1);

namespace Commet\Models;

abstract class PayoutVerification
{
    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return match ($data["outcome"] ?? null) {
            "existing" => PayoutVerificationVariant1::fromArray($data),
            "created" => PayoutVerificationVariant2::fromArray($data),
            default => PayoutVerificationVariant1::fromArray($data),
        };
    }
}
