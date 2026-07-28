<?php

declare(strict_types=1);

namespace Commet\Models;

class MarketGroup
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        /** @var string[] */
        public readonly array $countryCodes,
        /** @var array<string, mixed> */
        public readonly array $metadata,
        public readonly string $createdAt,
        public readonly string $updatedAt,
        public readonly string $object,
        public readonly bool $livemode,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data["id"],
            name: $data["name"],
            countryCodes: $data["country_codes"],
            metadata: $data["metadata"],
            createdAt: $data["created_at"],
            updatedAt: $data["updated_at"],
            object: $data["object"],
            livemode: $data["livemode"],
        );
    }
}
