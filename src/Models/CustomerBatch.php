<?php

declare(strict_types=1);

namespace Commet\Models;

class CustomerBatch
{
    public function __construct(
        /** @var CustomerBatchSuccessfulItem[] */
        public readonly array $successful,
        /** @var CustomerBatchFailedItem[] */
        public readonly array $failed,
        public readonly string $object,
        public readonly bool $livemode,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            successful: array_map(fn(array $item) => CustomerBatchSuccessfulItem::fromArray($item), $data["successful"]),
            failed: array_map(fn(array $item) => CustomerBatchFailedItem::fromArray($item), $data["failed"]),
            object: $data["object"],
            livemode: $data["livemode"],
        );
    }
}
