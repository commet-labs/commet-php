<?php

declare(strict_types=1);

namespace Commet\Models;

class UsageEvent
{
    public function __construct(
        public readonly string $id,
        public readonly string $featureCode,
        public readonly float $value,
        public readonly string $customerId,
        public readonly string $ts,
        public readonly string $createdAt,
        /** @var UsageEventPropertiesItem[] */
        public readonly array $properties,
        public readonly string $object,
        public readonly bool $livemode,
        public readonly ?string $eventId = null,
        public readonly ?UsageEventConsumption $consumption = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data["id"],
            featureCode: $data["feature_code"],
            value: $data["value"],
            customerId: $data["customer_id"],
            ts: $data["ts"],
            createdAt: $data["created_at"],
            properties: array_map(fn(array $item) => UsageEventPropertiesItem::fromArray($item), $data["properties"]),
            object: $data["object"],
            livemode: $data["livemode"],
            eventId: $data["event_id"] ?? null,
            consumption: isset($data["consumption"]) ? UsageEventConsumption::fromArray($data["consumption"]) : null,
        );
    }
}
