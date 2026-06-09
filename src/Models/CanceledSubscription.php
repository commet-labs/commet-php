<?php

declare(strict_types=1);

namespace Commet\Models;

use Commet\Enums\SubscriptionStatus;

class CanceledSubscription
{
    public function __construct(
        public readonly string $id,
        public readonly string $customerId,
        public readonly SubscriptionStatus $status,
        public readonly string $canceledAt,
        public readonly string $scheduledCancellationDate,
        public readonly string $updatedAt,
        public readonly string $object,
        public readonly bool $livemode,
        public readonly ?string $cancelReason = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data["id"],
            customerId: $data["customer_id"],
            status: SubscriptionStatus::from($data["status"]),
            canceledAt: $data["canceled_at"],
            scheduledCancellationDate: $data["scheduled_cancellation_date"],
            updatedAt: $data["updated_at"],
            object: $data["object"],
            livemode: $data["livemode"],
            cancelReason: $data["cancel_reason"] ?? null,
        );
    }
}
