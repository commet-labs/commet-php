<?php

declare(strict_types=1);

namespace Commet\Models;

class WebhookTest
{
    public function __construct(
        public readonly bool $success,
        public readonly string $deliveryId,
        public readonly string $deliveredAt,
        public readonly string $object,
        public readonly bool $livemode,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            success: $data["success"],
            deliveryId: $data["delivery_id"],
            deliveredAt: $data["delivered_at"],
            object: $data["object"],
            livemode: $data["livemode"],
        );
    }
}
