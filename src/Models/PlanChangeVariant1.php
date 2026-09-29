<?php

declare(strict_types=1);

namespace Commet\Models;

class PlanChangeVariant1 extends PlanChange implements \JsonSerializable
{
    public function __construct(
        public readonly string $outcome,
        public readonly mixed $requiresCheckout,
        public readonly string $checkoutUrl,
        public readonly string $object,
        public readonly bool $livemode,
        public readonly ?PlanChangeVariant1OfferApplication $offerApplication = null,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["outcome"] = $this->outcome;
        $values["requiresCheckout"] = $this->requiresCheckout;
        $values["checkoutUrl"] = $this->checkoutUrl;
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
            outcome: $data["outcome"],
            requiresCheckout: $data["requires_checkout"],
            checkoutUrl: $data["checkout_url"],
            object: $data["object"],
            livemode: $data["livemode"],
            offerApplication: isset($data["offer_application"]) ? PlanChangeVariant1OfferApplication::fromArray($data["offer_application"]) : null,
        );
    }
}
