<?php

declare(strict_types=1);

namespace Commet\Models;

class PaymentsListResult implements \JsonSerializable
{
    public function __construct(
        public readonly string $object,
        /** @var Payment[] */
        public readonly array $data,
        public readonly bool $hasMore,
        public readonly ?string $nextCursor = null,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["object"] = $this->object;
        $values["data"] = $this->data;
        $values["hasMore"] = $this->hasMore;
        if ($this->nextCursor !== null) {
            $values["nextCursor"] = $this->nextCursor;
        }
        return (object) $values;
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            object: $data["object"],
            data: array_map(fn(array $item) => Payment::fromArray($item), $data["data"]),
            hasMore: $data["has_more"],
            nextCursor: $data["next_cursor"] ?? null,
        );
    }
}
