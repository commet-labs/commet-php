<?php

declare(strict_types=1);

namespace Commet\Models;

class ReactivatedSubscription implements \JsonSerializable
{
    public function __construct(
        public readonly string $subscriptionId,
        public readonly string $invoiceId,
        public readonly string $status,
        public readonly string $object,
        public readonly bool $livemode,
        public readonly ?ReactivatedSubscriptionOfferApplication $offerApplication = null,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["subscriptionId"] = $this->subscriptionId;
        $values["invoiceId"] = $this->invoiceId;
        $values["status"] = $this->status;
        if ($this->offerApplication !== null) {
            $values["offerApplication"] = $this->offerApplication;
        }
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
            subscriptionId: $data["subscription_id"],
            invoiceId: $data["invoice_id"],
            status: $data["status"],
            object: $data["object"],
            livemode: $data["livemode"],
            offerApplication: isset($data["offer_application"]) ? ReactivatedSubscriptionOfferApplication::fromArray($data["offer_application"]) : null,
        );
    }
}
