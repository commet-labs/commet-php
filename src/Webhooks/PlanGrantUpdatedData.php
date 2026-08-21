<?php

declare(strict_types=1);

namespace Commet\Webhooks;

use Commet\Models\WebhookPlanGrantTimelineEvent;

/** Fired after a plan grant duration or deadline is durably changed. The payload is the grant snapshot at that update. */
final class PlanGrantUpdatedData
{
    public function __construct(
        public readonly string $id,
        public readonly string $customerId,
        public readonly string $subscriptionId,
        public readonly string $basePlanId,
        public readonly string $targetPlanId,
        public readonly string $targetPlanReleaseId,
        public readonly string $status,
        public readonly string $duration,
        public readonly ?int $durationCycles,
        public readonly string $startsAt,
        public readonly ?string $expiresAt,
        public readonly string $reason,
        public readonly string $source,
        public readonly ?string $revokedAt,
        public readonly string $createdAt,
        public readonly string $updatedAt,
        /** @var WebhookPlanGrantTimelineEvent[] */
        public readonly array $events,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data["id"],
            customerId: $data["customerId"],
            subscriptionId: $data["subscriptionId"],
            basePlanId: $data["basePlanId"],
            targetPlanId: $data["targetPlanId"],
            targetPlanReleaseId: $data["targetPlanReleaseId"],
            status: $data["status"],
            duration: $data["duration"],
            durationCycles: $data["durationCycles"] ?? null,
            startsAt: $data["startsAt"],
            expiresAt: $data["expiresAt"] ?? null,
            reason: $data["reason"],
            source: $data["source"],
            revokedAt: $data["revokedAt"] ?? null,
            createdAt: $data["createdAt"],
            updatedAt: $data["updatedAt"],
            events: array_map(fn(array $item) => WebhookPlanGrantTimelineEvent::fromArray($item), $data["events"] ?? []),
        );
    }
}
