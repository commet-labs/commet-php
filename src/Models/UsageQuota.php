<?php

declare(strict_types=1);

namespace Commet\Models;

class UsageQuota
{
    public function __construct(
        public readonly string $featureCode,
        public readonly float $current,
        public readonly float $included,
        public readonly float $billedQuantity,
        public readonly bool $unlimited,
        public readonly bool $overageEnabled,
        public readonly string $object,
        public readonly bool $livemode,
        public readonly ?float $remaining = null,
        public readonly ?string $asOf = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            featureCode: $data["feature_code"],
            current: $data["current"],
            included: $data["included"],
            billedQuantity: $data["billed_quantity"],
            unlimited: $data["unlimited"],
            overageEnabled: $data["overage_enabled"],
            object: $data["object"],
            livemode: $data["livemode"],
            remaining: $data["remaining"] ?? null,
            asOf: $data["as_of"] ?? null,
        );
    }
}
