<?php

declare(strict_types=1);

namespace Commet\Webhooks;

/** Fired when an add-on is activated on a subscription — via the API or a customer portal purchase. The prorated activation charge, if any, has already succeeded. Also fires customer.state_changed with trigger addon_activated. */
final class AddonActivatedData
{
    public function __construct(
        public readonly string $subscriptionId,
        public readonly string $customerId,
        public readonly WebhookAddonRef $addon,
        public readonly string $featureCode,
        public readonly float $proratedPrice,
        public readonly string $currency,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            subscriptionId: $data["subscriptionId"],
            customerId: $data["customerId"],
            addon: WebhookAddonRef::fromArray($data["addon"]),
            featureCode: $data["featureCode"],
            proratedPrice: $data["proratedPrice"],
            currency: $data["currency"],
        );
    }
}
