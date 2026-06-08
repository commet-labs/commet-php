<?php

declare(strict_types=1);

namespace Commet\Models;

class DefaultPlanPrice
{
    public function __construct(
        public readonly string $id,
        public readonly mixed $isDefault,
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
            isDefault: $data["is_default"],
            object: $data["object"],
            livemode: $data["livemode"],
        );
    }
}
