<?php

declare(strict_types=1);

namespace Commet\Models;

abstract class ReactivatedSubscriptionOfferApplicationAppliesTo
{
    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return match ($data["type"] ?? null) {
            "plan_price" => ReactivatedSubscriptionOfferApplicationAppliesToVariant1::fromArray($data),
            "addon" => ReactivatedSubscriptionOfferApplicationAppliesToVariant2::fromArray($data),
            "credit_pack" => ReactivatedSubscriptionOfferApplicationAppliesToVariant3::fromArray($data),
            default => ReactivatedSubscriptionOfferApplicationAppliesToVariant1::fromArray($data),
        };
    }
}
