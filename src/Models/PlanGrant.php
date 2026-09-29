<?php

declare(strict_types=1);

namespace Commet\Models;

class PlanGrant implements \JsonSerializable
{
    public function __construct(
        public readonly string $id,
        public readonly string $customerId,
        public readonly string $subscriptionId,
        public readonly string $basePlanId,
        public readonly string $planId,
        public readonly string $planReleaseId,
        public readonly string $status,
        public readonly string $duration,
        public readonly string $startsAt,
        public readonly string $reason,
        public readonly string $source,
        public readonly string $createdAt,
        public readonly string $updatedAt,
        /** @var PlanGrantEventsItem[] */
        public readonly array $events,
        public readonly string $object,
        public readonly bool $livemode,
        public readonly ?int $durationCycles = null,
        public readonly ?string $expiresAt = null,
        public readonly ?string $revokedAt = null,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["id"] = $this->id;
        $values["customerId"] = $this->customerId;
        $values["subscriptionId"] = $this->subscriptionId;
        $values["basePlanId"] = $this->basePlanId;
        $values["planId"] = $this->planId;
        $values["planReleaseId"] = $this->planReleaseId;
        $values["status"] = $this->status;
        $values["duration"] = $this->duration;
        $values["durationCycles"] = $this->durationCycles;
        $values["startsAt"] = $this->startsAt;
        $values["expiresAt"] = $this->expiresAt;
        $values["reason"] = $this->reason;
        $values["source"] = $this->source;
        $values["revokedAt"] = $this->revokedAt;
        $values["createdAt"] = $this->createdAt;
        $values["updatedAt"] = $this->updatedAt;
        $values["events"] = $this->events;
        $values["object"] = $this->object;
        $values["livemode"] = $this->livemode;
        return (object) $values;
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data["id"],
            customerId: $data["customer_id"],
            subscriptionId: $data["subscription_id"],
            basePlanId: $data["base_plan_id"],
            planId: $data["plan_id"],
            planReleaseId: $data["plan_release_id"],
            status: $data["status"],
            duration: $data["duration"],
            startsAt: $data["starts_at"],
            reason: $data["reason"],
            source: $data["source"],
            createdAt: $data["created_at"],
            updatedAt: $data["updated_at"],
            events: array_map(fn(array $item) => PlanGrantEventsItem::fromArray($item), $data["events"]),
            object: $data["object"],
            livemode: $data["livemode"],
            durationCycles: $data["duration_cycles"] ?? null,
            expiresAt: $data["expires_at"] ?? null,
            revokedAt: $data["revoked_at"] ?? null,
        );
    }
}
