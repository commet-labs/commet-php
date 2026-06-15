<?php

declare(strict_types=1);

namespace Commet\Webhooks;

final class WebhookCardInfo
{
    public function __construct(
        public readonly string $brand,
        public readonly string $last4,
        public readonly int $expMonth,
        public readonly int $expYear,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            brand: $data["brand"],
            last4: $data["last4"],
            expMonth: $data["expMonth"],
            expYear: $data["expYear"],
        );
    }
}
