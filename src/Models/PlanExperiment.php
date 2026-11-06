<?php

declare(strict_types=1);

namespace Commet\Models;

class PlanExperiment implements \JsonSerializable
{
    public function __construct(
        public readonly string $id,
        public readonly string $code,
        public readonly string $status,
        public readonly string $startedFromVersionId,
        public readonly string $latestVersionId,
        public readonly string $sellsVersionId,
        public readonly int $subscriptionCount,
        public readonly string $createdAt,
        public readonly string $object,
        public readonly bool $livemode,
        public readonly ?string $closedAt = null,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["id"] = $this->id;
        $values["code"] = $this->code;
        $values["status"] = $this->status;
        $values["startedFromVersionId"] = $this->startedFromVersionId;
        $values["latestVersionId"] = $this->latestVersionId;
        $values["sellsVersionId"] = $this->sellsVersionId;
        $values["subscriptionCount"] = $this->subscriptionCount;
        $values["createdAt"] = $this->createdAt;
        $values["closedAt"] = $this->closedAt;
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
            code: $data["code"],
            status: $data["status"],
            startedFromVersionId: $data["started_from_version_id"],
            latestVersionId: $data["latest_version_id"],
            sellsVersionId: $data["sells_version_id"],
            subscriptionCount: $data["subscription_count"],
            createdAt: $data["created_at"],
            object: $data["object"],
            livemode: $data["livemode"],
            closedAt: $data["closed_at"] ?? null,
        );
    }
}
