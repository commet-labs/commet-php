<?php

declare(strict_types=1);

namespace Commet\Models;

class SubscriptionResume implements \JsonSerializable
{
    public function __construct(
        public readonly string $subscriptionId,
        public readonly string $status,
        public readonly string $object,
        public readonly bool $livemode,
        public readonly ?string $invoiceId = null,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["subscriptionId"] = $this->subscriptionId;
        $values["invoiceId"] = $this->invoiceId;
        $values["status"] = $this->status;
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
            subscriptionId: $data["subscription_id"],
            status: $data["status"],
            object: $data["object"],
            livemode: $data["livemode"],
            invoiceId: $data["invoice_id"] ?? null,
        );
    }
}
