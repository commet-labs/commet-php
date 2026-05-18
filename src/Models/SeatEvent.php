<?php

declare(strict_types=1);

namespace Commet\Models;

class SeatEvent
{
    public function __construct(
        public readonly string $id,
        public readonly string $organizationId,
        public readonly string $customerId,
        public readonly string $featureCode,
        /** @deprecated Use $featureCode instead. */
        public readonly string $seatType,
        public readonly string $eventType,
        public readonly int $quantity,
        public readonly int $newBalance,
        public readonly string $ts,
        public readonly string $createdAt,
        public readonly ?int $previousBalance = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            organizationId: $data['organization_id'],
            customerId: $data['customer_id'],
            featureCode: $data['feature_code'] ?? $data['seat_type'] ?? '',
            seatType: $data['seat_type'] ?? '',
            eventType: $data['event_type'],
            quantity: $data['quantity'],
            newBalance: $data['new_balance'],
            ts: $data['ts'],
            createdAt: $data['created_at'],
            previousBalance: $data['previous_balance'] ?? null,
        );
    }
}
