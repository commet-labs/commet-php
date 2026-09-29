<?php

declare(strict_types=1);

namespace Commet\Webhooks;

/** Fired when a period-end pause is scheduled. Access and billing continue until effectiveAt. */
final class SubscriptionPauseScheduledData
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
