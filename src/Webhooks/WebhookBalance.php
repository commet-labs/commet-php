<?php

declare(strict_types=1);

namespace Commet\Webhooks;

final class WebhookBalance
{
    public function __construct(
        public readonly float $currentBalance,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            currentBalance: $data["currentBalance"],
        );
    }
}
