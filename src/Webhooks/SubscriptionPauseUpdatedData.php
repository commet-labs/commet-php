<?php

declare(strict_types=1);

namespace Commet\Webhooks;

/** Fired when the finite or indefinite pause duration changes. */
final class SubscriptionPauseUpdatedData
{
    public function __construct(
        public readonly string $subscriptionId,
        public readonly string $customerId,
        public readonly string $status,
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
            effectiveAt: $data["effectiveAt"],
            resumeAt: $data["resumeAt"] ?? null,
        );
    }
}
