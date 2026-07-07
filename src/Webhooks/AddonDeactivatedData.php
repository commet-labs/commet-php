<?php

declare(strict_types=1);

namespace Commet\Webhooks;

use Commet\Models\WebhookAddonRef;

/** Fired when an active add-on is deactivated from a subscription. Also fires customer.state_changed with trigger addon_deactivated. */
final class AddonDeactivatedData
{
    public function __construct(
        public readonly string $subscriptionId,
        public readonly string $customerId,
        public readonly WebhookAddonRef $addon,
        public readonly string $featureCode,
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
        );
    }
}
