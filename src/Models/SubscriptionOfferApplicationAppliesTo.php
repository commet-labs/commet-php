<?php

declare(strict_types=1);

namespace Commet\Models;

abstract class SubscriptionOfferApplicationAppliesTo
{
    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return match ($data["type"] ?? null) {
            "plan_price" => SubscriptionOfferApplicationAppliesToVariant1::fromArray($data),
            "addon" => SubscriptionOfferApplicationAppliesToVariant2::fromArray($data),
            "credit_pack" => SubscriptionOfferApplicationAppliesToVariant3::fromArray($data),
            default => SubscriptionOfferApplicationAppliesToVariant1::fromArray($data),
        };
    }
}
