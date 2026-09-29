<?php

declare(strict_types=1);

namespace Commet\Models;

class SubscriptionAddon implements \JsonSerializable
{
    public function __construct(
        public readonly string $addonId,
        public readonly string $status,
        public readonly int $proratedCharge,
        public readonly string $object,
        public readonly bool $livemode,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["addonId"] = $this->addonId;
        $values["status"] = $this->status;
        $values["proratedCharge"] = $this->proratedCharge;
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
            addonId: $data["addon_id"],
            status: $data["status"],
            proratedCharge: $data["prorated_charge"],
            object: $data["object"],
            livemode: $data["livemode"],
        );
    }
}
