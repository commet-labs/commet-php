<?php

declare(strict_types=1);

namespace Commet\Models;

class SubscriptionBalance
{
    public function __construct(
        public readonly float $remaining,
        public readonly float $included,
        public readonly string $currency,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            remaining: $data["remaining"],
            included: $data["included"],
            currency: $data["currency"],
        );
    }
}
