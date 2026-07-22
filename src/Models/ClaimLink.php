<?php

declare(strict_types=1);

namespace Commet\Models;

class ClaimLink
{
    public function __construct(
        public readonly string $url,
        public readonly string $expiresAt,
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
            expiresAt: $data["expires_at"],
            object: $data["object"],
            livemode: $data["livemode"],
        );
    }
}
