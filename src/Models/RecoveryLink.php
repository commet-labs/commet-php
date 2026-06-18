<?php

declare(strict_types=1);

namespace Commet\Models;

class RecoveryLink
{
    public function __construct(
        public readonly string $url,
        public readonly string $token,
        public readonly string $object,
        public readonly bool $livemode,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            url: $data["url"],
            token: $data["token"],
            object: $data["object"],
            livemode: $data["livemode"],
        );
    }
}
