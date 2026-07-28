<?php

declare(strict_types=1);

namespace Commet\Models;

class ReactivatedSubscription
{
    public function __construct(
        public readonly string $subscriptionId,
        public readonly string $invoiceId,
        public readonly string $status,
        public readonly string $object,
        public readonly bool $livemode,
        public readonly ?ReactivatedSubscriptionOfferApplication $offerApplication = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            subscriptionId: $data["subscription_id"],
            invoiceId: $data["invoice_id"],
            status: $data["status"],
            object: $data["object"],
            livemode: $data["livemode"],
            offerApplication: isset($data["offer_application"]) ? ReactivatedSubscriptionOfferApplication::fromArray($data["offer_application"]) : null,
        );
    }
}
