<?php

declare(strict_types=1);

namespace Commet\Models;

class UsageAdjustment
{
    public function __construct(
        public readonly string $id,
        public readonly int $value,
        public readonly int $previousValue,
        public readonly int $adjustment,
        public readonly string $customerId,
        public readonly string $ts,
        public readonly string $createdAt,
        public readonly string $featureCode,
        public readonly string $object,
        public readonly bool $livemode,
        public readonly ?string $reason = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data["id"],
            value: $data["value"],
            previousValue: $data["previous_value"],
            adjustment: $data["adjustment"],
            customerId: $data["customer_id"],
            ts: $data["ts"],
            createdAt: $data["created_at"],
            featureCode: $data["feature_code"],
            object: $data["object"],
            livemode: $data["livemode"],
            reason: $data["reason"] ?? null,
        );
    }
}
