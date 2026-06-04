<?php

declare(strict_types=1);

namespace Commet\Models;

class InvoiceDownloadResult
{
    public function __construct(
        public readonly string $url,
        public readonly string $expiresAt,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            url: $data['url'],
            expiresAt: $data['expires_at'],
        );
    }
}
