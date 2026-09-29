<?php

declare(strict_types=1);

namespace Commet\Webhooks;

/** Fired after a paused subscription restores access. */
final class SubscriptionResumedData
{
    public function __construct(
        public readonly string $subscriptionId,
        public readonly string $customerId,
        public readonly string $status,
        public readonly string $mode,
        public readonly string $resumedAt,
        public readonly ?string $invoiceId,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            subscriptionId: $data["subscriptionId"],
            customerId: $data["customerId"],
            status: $data["status"],
            mode: $data["mode"],
            resumedAt: $data["resumedAt"],
            invoiceId: $data["invoiceId"] ?? null,
        );
    }
}
