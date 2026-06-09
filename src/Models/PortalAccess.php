<?php

declare(strict_types=1);

namespace Commet\Models;

class PortalAccess
{
    public function __construct(
        public readonly string $portalUrl,
        public readonly string $object,
        public readonly bool $livemode,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            portalUrl: $data["portal_url"],
            object: $data["object"],
            livemode: $data["livemode"],
        );
    }
}
