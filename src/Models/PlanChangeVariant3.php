<?php

declare(strict_types=1);

namespace Commet\Models;

class PlanChangeVariant3 extends PlanChange
{
    public function __construct(
        public readonly string $outcome,
        public readonly string $id,
        public readonly mixed $scheduled,
        public readonly string $customerId,
        public readonly PlanChangeVariant3PreviousPlan $previousPlan,
        public readonly PlanChangeVariant3CurrentPlan $currentPlan,
        public readonly string $billingInterval,
        public readonly PlanChangeVariant3Billing $billing,
        public readonly string $object,
        public readonly bool $livemode,
        public readonly ?string $invoiceId = null,
        public readonly ?PlanChangeVariant3OfferApplication $offerApplication = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            outcome: $data["outcome"],
            id: $data["id"],
            scheduled: $data["scheduled"],
            customerId: $data["customer_id"],
            previousPlan: PlanChangeVariant3PreviousPlan::fromArray($data["previous_plan"]),
            currentPlan: PlanChangeVariant3CurrentPlan::fromArray($data["current_plan"]),
            billingInterval: $data["billing_interval"],
            billing: PlanChangeVariant3Billing::fromArray($data["billing"]),
            object: $data["object"],
            livemode: $data["livemode"],
            invoiceId: $data["invoice_id"] ?? null,
            offerApplication: isset($data["offer_application"]) ? PlanChangeVariant3OfferApplication::fromArray($data["offer_application"]) : null,
        );
    }
}
