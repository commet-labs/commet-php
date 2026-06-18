<?php

declare(strict_types=1);

namespace Commet\Models;

class ReactivatedSubscription
{
    public function __construct(
        public readonly string $id,
        public readonly bool $retryInitiated,
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
            retryInitiated: $data["retry_initiated"],
            object: $data["object"],
            livemode: $data["livemode"],
        );
    }
}
