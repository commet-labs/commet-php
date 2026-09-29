<?php

declare(strict_types=1);

namespace Commet\Webhooks;

/** Fired when a pause becomes effective and access is revoked. */
final class SubscriptionPausedData
{
    public function __construct(
        public readonly string $subscriptionId,
        public readonly string $customerId,
        public readonly string $status,
        public readonly string $mode,
        public readonly string $effectiveAt,
        public readonly ?string $resumeAt,
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
            effectiveAt: $data["effectiveAt"],
            resumeAt: $data["resumeAt"] ?? null,
        );
    }
}
