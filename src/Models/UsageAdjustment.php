<?php

declare(strict_types=1);

namespace Commet\Models;

class UsageAdjustment implements \JsonSerializable
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

    public function jsonSerialize(): object
    {
        $values = [];
        $values["id"] = $this->id;
        $values["value"] = $this->value;
        $values["previousValue"] = $this->previousValue;
        $values["adjustment"] = $this->adjustment;
        $values["customerId"] = $this->customerId;
        $values["reason"] = $this->reason;
        $values["ts"] = $this->ts;
        $values["createdAt"] = $this->createdAt;
        $values["featureCode"] = $this->featureCode;
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
