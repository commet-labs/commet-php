<?php

declare(strict_types=1);

namespace Commet\Models;

class SubscriptionAddon
{
    public function __construct(
        public readonly string $addonId,
        public readonly string $status,
        public readonly int $proratedCharge,
        public readonly string $object,
        public readonly bool $livemode,
    ) {}

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
