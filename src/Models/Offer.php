<?php

declare(strict_types=1);

namespace Commet\Models;

class Offer
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        /** @var OfferPhasesItem[] */
        public readonly array $phases,
        /** @var array<string, mixed> */
        public readonly array $metadata,
        public readonly bool $active,
        public readonly string $createdAt,
        public readonly string $updatedAt,
        public readonly string $object,
        public readonly bool $livemode,
        public readonly ?string $startsAt = null,
        public readonly ?string $endsAt = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data["id"],
            name: $data["name"],
            phases: array_map(fn(array $item) => OfferPhasesItem::fromArray($item), $data["phases"]),
            metadata: $data["metadata"],
            active: $data["active"],
            createdAt: $data["created_at"],
            updatedAt: $data["updated_at"],
            object: $data["object"],
            livemode: $data["livemode"],
            startsAt: $data["starts_at"] ?? null,
            endsAt: $data["ends_at"] ?? null,
        );
    }
}
