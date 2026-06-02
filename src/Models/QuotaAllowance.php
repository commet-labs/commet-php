<?php

declare(strict_types=1);

namespace Commet\Models;

class QuotaAllowance
{
    public function __construct(
        public readonly string $featureCode,
        public readonly int $current,
        public readonly int $included,
        public readonly ?int $remaining,
        public readonly ?int $billedQuantity,
        public readonly bool $unlimited,
        public readonly bool $overageEnabled,
        public readonly ?string $asOf,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            featureCode: $data['featureCode'],
            current: $data['current'],
            included: $data['included'],
            remaining: $data['remaining'] ?? null,
            billedQuantity: $data['billedQuantity'] ?? null,
            unlimited: $data['unlimited'],
            overageEnabled: $data['overageEnabled'],
            asOf: $data['asOf'] ?? null,
        );
    }
}
