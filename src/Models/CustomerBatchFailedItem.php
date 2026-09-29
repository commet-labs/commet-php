<?php

declare(strict_types=1);

namespace Commet\Models;

class CustomerBatchFailedItem implements \JsonSerializable
{
    public function __construct(
        public readonly int $index,
        public readonly string $error,
        public readonly CustomerBatchFailedItemData $data,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["index"] = $this->index;
        $values["error"] = $this->error;
        $values["data"] = $this->data;
        return (object) $values;
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            index: $data["index"],
            error: $data["error"],
            data: CustomerBatchFailedItemData::fromArray($data["data"]),
        );
    }
}
