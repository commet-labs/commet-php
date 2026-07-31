<?php

declare(strict_types=1);

namespace Commet\Models;

abstract class SubscriptionOfferApplicationPhase
{
    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return match ($data["type"] ?? null) {
            "free_trial" => SubscriptionOfferApplicationPhaseVariant1::fromArray($data),
            "percentage" => SubscriptionOfferApplicationPhaseVariant2::fromArray($data),
            "amount_off" => SubscriptionOfferApplicationPhaseVariant3::fromArray($data),
            "fixed_price" => SubscriptionOfferApplicationPhaseVariant4::fromArray($data),
            default => SubscriptionOfferApplicationPhaseVariant1::fromArray($data),
        };
    }
}
