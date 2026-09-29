<?php

declare(strict_types=1);

namespace Commet\Models;

class TestClockRun implements \JsonSerializable
{
    public function __construct(
        public readonly string $id,
        public readonly string $status,
        public readonly string $startedAtTime,
        public readonly string $targetTime,
        public readonly int $estimatedDeadlineCount,
        public readonly int $completedDeadlineCount,
        public readonly int $failedDeadlineCount,
        /** @var TestClockRunItemsItem[] */
        public readonly array $items,
        public readonly string $object,
        public readonly bool $livemode,
        public readonly ?string $error = null,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["id"] = $this->id;
        $values["status"] = $this->status;
        $values["startedAtTime"] = $this->startedAtTime;
        $values["targetTime"] = $this->targetTime;
        $values["estimatedDeadlineCount"] = $this->estimatedDeadlineCount;
        $values["completedDeadlineCount"] = $this->completedDeadlineCount;
        $values["failedDeadlineCount"] = $this->failedDeadlineCount;
        $values["error"] = $this->error;
        $values["items"] = $this->items;
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
            status: $data["status"],
            startedAtTime: $data["started_at_time"],
            targetTime: $data["target_time"],
            estimatedDeadlineCount: $data["estimated_deadline_count"],
            completedDeadlineCount: $data["completed_deadline_count"],
            failedDeadlineCount: $data["failed_deadline_count"],
            items: array_map(fn(array $item) => TestClockRunItemsItem::fromArray($item), $data["items"]),
            object: $data["object"],
            livemode: $data["livemode"],
            error: $data["error"] ?? null,
        );
    }
}
