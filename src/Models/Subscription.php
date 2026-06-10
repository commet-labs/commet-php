<?php

declare(strict_types=1);

namespace Commet\Models;

use Commet\Enums\BillingInterval;
use Commet\Enums\ConsumptionModel;
use Commet\Enums\DiscountType;
use Commet\Enums\FeatureType;
use Commet\Enums\SubscriptionStatus;

class Subscription
{
    public function __construct(
        public readonly string $id,
        public readonly string $customerId,
        /** @var array<string, mixed> */
        public readonly array $plan,
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
        public readonly ?ConsumptionModel $consumptionModel = null,
        public readonly ?string $trialEndsAt = null,
        /** @var array<string, mixed>|null */
        public readonly ?array $currentPeriod = null,
        /** @var list<array<string, mixed>>|null */
        public readonly ?array $features = null,
        /** @var array<string, mixed>|null */
        public readonly ?array $credits = null,
        /** @var array<string, mixed>|null */
        public readonly ?array $balance = null,
        /** @var array<string, mixed>|null */
        public readonly ?array $cancellation = null,
        /** @var array<string, mixed>|null */
        public readonly ?array $scheduledPlanChange = null,
        /** @var array<string, mixed>|null */
        public readonly ?array $discount = null,
        public readonly ?string $endDate = null,
        public readonly ?int $billingDayOfMonth = null,
        public readonly ?string $nextBillingDate = null,
        public readonly ?string $checkoutUrl = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data["id"],
            customerId: $data["customer_id"],
            plan: $data["plan"],
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
            consumptionModel: isset($data["consumption_model"]) ? ConsumptionModel::from($data["consumption_model"]) : null,
            trialEndsAt: $data["trial_ends_at"] ?? null,
            currentPeriod: $data["current_period"] ?? null,
            features: $data["features"] ?? null,
            credits: $data["credits"] ?? null,
            balance: $data["balance"] ?? null,
            cancellation: $data["cancellation"] ?? null,
            scheduledPlanChange: $data["scheduled_plan_change"] ?? null,
            discount: $data["discount"] ?? null,
            endDate: $data["end_date"] ?? null,
            billingDayOfMonth: $data["billing_day_of_month"] ?? null,
            nextBillingDate: $data["next_billing_date"] ?? null,
            checkoutUrl: $data["checkout_url"] ?? null,
        );
    }
}
