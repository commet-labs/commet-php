<?php

declare(strict_types=1);

namespace Commet\Models;

abstract class ReactivatedSubscriptionOfferApplicationPhasesItem
{
    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return match ($data["type"] ?? null) {
            "percentage" => ReactivatedSubscriptionOfferApplicationPhasesItemVariant1::fromArray($data),
            "amount_off" => ReactivatedSubscriptionOfferApplicationPhasesItemVariant2::fromArray($data),
            "fixed_price" => ReactivatedSubscriptionOfferApplicationPhasesItemVariant3::fromArray($data),
            default => ReactivatedSubscriptionOfferApplicationPhasesItemVariant1::fromArray($data),
        };
    }
}
