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
            "free_trial" => ReactivatedSubscriptionOfferApplicationPhasesItemVariant1::fromArray($data),
            "percentage" => ReactivatedSubscriptionOfferApplicationPhasesItemVariant2::fromArray($data),
            "amount_off" => ReactivatedSubscriptionOfferApplicationPhasesItemVariant3::fromArray($data),
            "fixed_price" => ReactivatedSubscriptionOfferApplicationPhasesItemVariant4::fromArray($data),
            default => ReactivatedSubscriptionOfferApplicationPhasesItemVariant1::fromArray($data),
        };
    }
}
