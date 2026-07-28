<?php

declare(strict_types=1);

namespace Commet\Models;

class SubscriptionsListResult
{
    public function __construct(
        public readonly string $object,
        /** @var SubscriptionSummary[] */
        public readonly array $data,
        public readonly bool $hasMore,
        public readonly ?string $nextCursor = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            object: $data["object"],
            data: array_map(fn(array $item) => SubscriptionSummary::fromArray($item), $data["data"]),
            hasMore: $data["has_more"],
            nextCursor: $data["next_cursor"] ?? null,
        );
    }
}
