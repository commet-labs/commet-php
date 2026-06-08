<?php

declare(strict_types=1);

namespace Commet\Models;

class SeatEvent
{
    public function __construct(
        public readonly string $id,
        public readonly string $customerId,
        public readonly string $featureCode,
        public readonly int $previousBalance,
        public readonly int $newBalance,
        public readonly string $ts,
        public readonly string $createdAt,
        public readonly string $object,
        public readonly bool $livemode,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data["id"],
            customerId: $data["customer_id"],
            featureCode: $data["feature_code"],
            previousBalance: $data["previous_balance"],
            newBalance: $data["new_balance"],
            ts: $data["ts"],
            createdAt: $data["created_at"],
            object: $data["object"],
            livemode: $data["livemode"],
        );
    }
}
