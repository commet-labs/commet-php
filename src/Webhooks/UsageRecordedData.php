<?php

declare(strict_types=1);

namespace Commet\Webhooks;

/** Fired for every processed usage event. HIGH VOLUME: this fires once per tracked event, so it is excluded from family select-all in the dashboard — subscribe to it explicitly and make sure your endpoint can absorb your own ingest rate. */
final class UsageRecordedData
{
    public function __construct(
        public readonly string $subscriptionId,
        public readonly string $customerId,
        public readonly string $usageEventId,
        public readonly string $featureCode,
        public readonly float $value,
        public readonly string $ts,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            subscriptionId: $data["subscriptionId"],
            customerId: $data["customerId"],
            usageEventId: $data["usageEventId"],
            featureCode: $data["featureCode"],
            value: $data["value"],
            ts: $data["ts"],
        );
    }
}
