<?php

declare(strict_types=1);

namespace Commet\Models;

class UsageAdjustment
{
    public function __construct(
        public readonly string $id,
        public readonly string $feature,
        public readonly int $value,
        public readonly int $previousValue,
        public readonly int $adjustment,
        public readonly string $customerId,
        public readonly string $ts,
        public readonly string $createdAt,
        public readonly string $object,
        public readonly bool $livemode,
        public readonly ?string $idempotencyKey = null,
        public readonly ?string $reason = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            feature: $data['feature'],
            value: $data['value'],
            previousValue: $data['previous_value'],
            adjustment: $data['adjustment'],
            customerId: $data['customer_id'],
            ts: $data['ts'],
            createdAt: $data['created_at'],
            object: $data['object'],
            livemode: $data['livemode'],
            idempotencyKey: $data['idempotency_key'] ?? null,
            reason: $data['reason'] ?? null,
        );
    }
}
