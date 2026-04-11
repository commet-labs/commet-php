<?php

declare(strict_types=1);

namespace Commet\Models;

class PortalSession
{
    public function __construct(
        public readonly string $portalUrl,
        public readonly ?string $message = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            portalUrl: $data['portal_url'],
            message: $data['message'] ?? null,
        );
    }
}
