<?php

declare(strict_types=1);

namespace Commet\Models;

class PlanChange
{
    public function __construct(
        public readonly string $object,
        public readonly bool $livemode,
        public readonly ?bool $requiresCheckout = null,
        public readonly ?string $checkoutUrl = null,
        public readonly ?string $id = null,
        public readonly ?bool $scheduled = null,
        public readonly ?string $scheduledFor = null,
        public readonly ?string $changeType = null,
        public readonly ?string $customerId = null,
        public readonly ?string $newPlanId = null,
        public readonly ?string $newPlanName = null,
        public readonly ?string $newBillingInterval = null,
        /** @var array<string, mixed>|null */
        public readonly ?array $previousPlan = null,
        /** @var array<string, mixed>|null */
        public readonly ?array $currentPlan = null,
        public readonly ?string $billingInterval = null,
        /** @var array<string, mixed>|null */
        public readonly ?array $billing = null,
        public readonly ?string $invoiceId = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            object: $data["object"],
            livemode: $data["livemode"],
            requiresCheckout: $data["requires_checkout"] ?? null,
            checkoutUrl: $data["checkout_url"] ?? null,
            id: $data["id"] ?? null,
            scheduled: $data["scheduled"] ?? null,
            scheduledFor: $data["scheduled_for"] ?? null,
            changeType: $data["change_type"] ?? null,
            customerId: $data["customer_id"] ?? null,
            newPlanId: $data["new_plan_id"] ?? null,
            newPlanName: $data["new_plan_name"] ?? null,
            newBillingInterval: $data["new_billing_interval"] ?? null,
            previousPlan: $data["previous_plan"] ?? null,
            currentPlan: $data["current_plan"] ?? null,
            billingInterval: $data["billing_interval"] ?? null,
            billing: $data["billing"] ?? null,
            invoiceId: $data["invoice_id"] ?? null,
        );
    }
}
