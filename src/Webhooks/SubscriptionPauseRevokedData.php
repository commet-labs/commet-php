<?php

declare(strict_types=1);

namespace Commet\Webhooks;

/** Fired when a scheduled pause is revoked before it becomes effective. */
final class SubscriptionPauseRevokedData
{
    public function __construct(
        public readonly string $subscriptionId,
        public readonly string $customerId,
        public readonly string $status,
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
        );
    }
}
