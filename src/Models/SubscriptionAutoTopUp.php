<?php

declare(strict_types=1);

namespace Commet\Models;

class SubscriptionAutoTopUp implements \JsonSerializable
{
    public function __construct(
        public readonly bool $enabled,
        public readonly string $status,
        public readonly int $topUpsThisPeriod,
        public readonly string $object,
        public readonly bool $livemode,
        public readonly ?int $threshold = null,
        public readonly ?int $quantity = null,
        public readonly ?int $amount = null,
        public readonly ?int $maxPerPeriod = null,
        public readonly ?string $periodResetsAt = null,
        public readonly ?SubscriptionAutoTopUpLastFailure $lastFailure = null,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["enabled"] = $this->enabled;
        $values["threshold"] = $this->threshold;
        $values["quantity"] = $this->quantity;
        $values["amount"] = $this->amount;
        $values["maxPerPeriod"] = $this->maxPerPeriod;
        $values["status"] = $this->status;
        $values["topUpsThisPeriod"] = $this->topUpsThisPeriod;
        $values["periodResetsAt"] = $this->periodResetsAt;
        $values["lastFailure"] = $this->lastFailure;
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
            enabled: $data["enabled"],
            status: $data["status"],
            topUpsThisPeriod: $data["top_ups_this_period"],
            object: $data["object"],
            livemode: $data["livemode"],
            threshold: $data["threshold"] ?? null,
            quantity: $data["quantity"] ?? null,
            amount: $data["amount"] ?? null,
            maxPerPeriod: $data["max_per_period"] ?? null,
            periodResetsAt: $data["period_resets_at"] ?? null,
            lastFailure: isset($data["last_failure"]) ? SubscriptionAutoTopUpLastFailure::fromArray($data["last_failure"]) : null,
        );
    }
}
