<?php

declare(strict_types=1);

namespace Commet\Models;

class TestClockLatestRun
{
    public function __construct(
        public readonly string $id,
        public readonly string $status,
        public readonly string $startedAtTime,
        public readonly string $targetTime,
        public readonly int $estimatedDeadlineCount,
        public readonly int $completedDeadlineCount,
        public readonly int $failedDeadlineCount,
        /** @var TestClockLatestRunItemsItem[] */
        public readonly array $items,
        public readonly ?string $error = null,
    ) {}

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
            items: array_map(fn(array $item) => TestClockLatestRunItemsItem::fromArray($item), $data["items"]),
            error: $data["error"] ?? null,
        );
    }
}
