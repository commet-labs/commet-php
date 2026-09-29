<?php

declare(strict_types=1);

namespace Commet\Models;

class WebhookTest implements \JsonSerializable
{
    public function __construct(
        public readonly bool $success,
        public readonly string $deliveryId,
        public readonly string $deliveredAt,
        public readonly string $object,
        public readonly bool $livemode,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["success"] = $this->success;
        $values["deliveryId"] = $this->deliveryId;
        $values["deliveredAt"] = $this->deliveredAt;
        $values["object"] = $this->object;
        $values["livemode"] = $this->livemode;
        return (object) $values;
    }

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
