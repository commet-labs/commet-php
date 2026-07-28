<?php

declare(strict_types=1);

namespace Commet\Models;

use Commet\Enums\BillingInterval;
use Commet\Enums\PaymentProvider;
use Commet\Enums\SubscriptionStatus;

class CreatedSubscription
{
    public function __construct(
        public readonly string $id,
        public readonly string $customerId,
        public readonly CreatedSubscriptionPlan $plan,
        public readonly string $name,
        public readonly SubscriptionStatus $status,
        public readonly bool $cancelAtPeriodEnd,
        public readonly string $startDate,
        public readonly string $createdAt,
        public readonly string $updatedAt,
        public readonly string $object,
        public readonly bool $livemode,
        public readonly ?string $description = null,
        public readonly ?BillingInterval $billingInterval = null,
        public readonly ?string $trialEndsAt = null,
        public readonly ?CreatedSubscriptionCurrentPeriod $currentPeriod = null,
        public readonly ?CreatedSubscriptionCancellation $cancellation = null,
        public readonly ?CreatedSubscriptionScheduledPlanChange $scheduledPlanChange = null,
        public readonly ?CreatedSubscriptionDiscount $discount = null,
        public readonly ?string $endDate = null,
        public readonly ?int $billingDayOfMonth = null,
        public readonly ?string $nextBillingDate = null,
        public readonly ?string $checkoutUrl = null,
        public readonly ?PaymentProvider $checkoutProvider = null,
        public readonly ?string $priceId = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data["id"],
            customerId: $data["customer_id"],
            plan: CreatedSubscriptionPlan::fromArray($data["plan"]),
            name: $data["name"],
            status: SubscriptionStatus::from($data["status"]),
            cancelAtPeriodEnd: $data["cancel_at_period_end"],
            startDate: $data["start_date"],
            createdAt: $data["created_at"],
            updatedAt: $data["updated_at"],
            object: $data["object"],
            livemode: $data["livemode"],
            description: $data["description"] ?? null,
            billingInterval: isset($data["billing_interval"]) ? BillingInterval::from($data["billing_interval"]) : null,
            trialEndsAt: $data["trial_ends_at"] ?? null,
            currentPeriod: isset($data["current_period"]) ? CreatedSubscriptionCurrentPeriod::fromArray($data["current_period"]) : null,
            cancellation: isset($data["cancellation"]) ? CreatedSubscriptionCancellation::fromArray($data["cancellation"]) : null,
            scheduledPlanChange: isset($data["scheduled_plan_change"]) ? CreatedSubscriptionScheduledPlanChange::fromArray($data["scheduled_plan_change"]) : null,
            discount: isset($data["discount"]) ? CreatedSubscriptionDiscount::fromArray($data["discount"]) : null,
            endDate: $data["end_date"] ?? null,
            billingDayOfMonth: $data["billing_day_of_month"] ?? null,
            nextBillingDate: $data["next_billing_date"] ?? null,
            checkoutUrl: $data["checkout_url"] ?? null,
            checkoutProvider: isset($data["checkout_provider"]) ? PaymentProvider::from($data["checkout_provider"]) : null,
            priceId: $data["price_id"] ?? null,
        );
    }
}
