<?php

declare(strict_types=1);

namespace Commet\Models;

class InvoiceSendResult
{
    public function __construct(
        public readonly bool $sent,
        public readonly string $sentAt,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            sent: $data['sent'],
            sentAt: $data['sent_at'],
        );
    }
}
