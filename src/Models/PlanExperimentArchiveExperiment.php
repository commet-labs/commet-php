<?php

declare(strict_types=1);

namespace Commet\Models;

class PlanExperimentArchiveExperiment implements \JsonSerializable
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
            closedAt: $data["closed_at"] ?? null,
        );
    }
}
