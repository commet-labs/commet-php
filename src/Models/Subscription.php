<?php

declare(strict_types=1);

namespace Commet\Models;

use Commet\Enums\BillingInterval;
use Commet\Enums\ConsumptionModel;
use Commet\Enums\SubscriptionStatus;

class Subscription implements \JsonSerializable
{
    public function __construct(
        public readonly string $id,
        public readonly string $customerId,
        public readonly SubscriptionPlan $plan,
        public readonly string $name,
        public readonly SubscriptionStatus $status,
        public readonly bool $cancelAtPeriodEnd,
        public readonly string $startDate,
        public readonly string $createdAt,
        public readonly string $updatedAt,
        /** @var SubscriptionOfferApplication[] */
        public readonly array $offerApplications,
        /** @var SubscriptionFeaturesItem[] */
        public readonly array $features,
        public readonly string $object,
        public readonly bool $livemode,
        public readonly ?string $description = null,
        public readonly ?BillingInterval $billingInterval = null,
        public readonly ?string $trialEndsAt = null,
        public readonly ?SubscriptionCurrentPeriod $currentPeriod = null,
        public readonly ?SubscriptionCancellation $cancellation = null,
        public readonly ?SubscriptionScheduledPlanChange $scheduledPlanChange = null,
        public readonly ?string $endDate = null,
        public readonly ?int $billingDayOfMonth = null,
        public readonly ?string $nextBillingDate = null,
        public readonly ?string $checkoutUrl = null,
        public readonly ?SubscriptionPause $pause = null,
        public readonly ?SubscriptionPlanGrant $planGrant = null,
        public readonly ?ConsumptionModel $consumptionModel = null,
        public readonly ?SubscriptionCredits $credits = null,
        public readonly ?SubscriptionBalance $balance = null,
        public readonly ?string $priceId = null,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["id"] = $this->id;
        $values["customerId"] = $this->customerId;
        $values["plan"] = $this->plan;
        $values["name"] = $this->name;
        $values["description"] = $this->description;
        $values["status"] = $this->status;
        $values["billingInterval"] = $this->billingInterval;
        $values["trialEndsAt"] = $this->trialEndsAt;
        $values["currentPeriod"] = $this->currentPeriod;
        $values["cancellation"] = $this->cancellation;
        $values["cancelAtPeriodEnd"] = $this->cancelAtPeriodEnd;
        $values["scheduledPlanChange"] = $this->scheduledPlanChange;
        $values["startDate"] = $this->startDate;
        $values["endDate"] = $this->endDate;
        $values["billingDayOfMonth"] = $this->billingDayOfMonth;
        $values["nextBillingDate"] = $this->nextBillingDate;
        $values["checkoutUrl"] = $this->checkoutUrl;
        $values["createdAt"] = $this->createdAt;
        $values["updatedAt"] = $this->updatedAt;
        $values["offerApplications"] = $this->offerApplications;
        $values["pause"] = $this->pause;
        if ($this->planGrant !== null) {
            $values["planGrant"] = $this->planGrant;
        }
        $values["consumptionModel"] = $this->consumptionModel;
        $values["features"] = $this->features;
        $values["credits"] = $this->credits;
        $values["balance"] = $this->balance;
        $values["priceId"] = $this->priceId;
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
            id: $data["id"],
            customerId: $data["customer_id"],
            plan: SubscriptionPlan::fromArray($data["plan"]),
            name: $data["name"],
            status: SubscriptionStatus::from($data["status"]),
            cancelAtPeriodEnd: $data["cancel_at_period_end"],
            startDate: $data["start_date"],
            createdAt: $data["created_at"],
            updatedAt: $data["updated_at"],
            offerApplications: array_map(fn(array $item) => SubscriptionOfferApplication::fromArray($item), $data["offer_applications"]),
            features: array_map(fn(array $item) => SubscriptionFeaturesItem::fromArray($item), $data["features"]),
            object: $data["object"],
            livemode: $data["livemode"],
            description: $data["description"] ?? null,
            billingInterval: isset($data["billing_interval"]) ? BillingInterval::from($data["billing_interval"]) : null,
            trialEndsAt: $data["trial_ends_at"] ?? null,
            currentPeriod: isset($data["current_period"]) ? SubscriptionCurrentPeriod::fromArray($data["current_period"]) : null,
            cancellation: isset($data["cancellation"]) ? SubscriptionCancellation::fromArray($data["cancellation"]) : null,
            scheduledPlanChange: isset($data["scheduled_plan_change"]) ? SubscriptionScheduledPlanChange::fromArray($data["scheduled_plan_change"]) : null,
            endDate: $data["end_date"] ?? null,
            billingDayOfMonth: $data["billing_day_of_month"] ?? null,
            nextBillingDate: $data["next_billing_date"] ?? null,
            checkoutUrl: $data["checkout_url"] ?? null,
            pause: isset($data["pause"]) ? SubscriptionPause::fromArray($data["pause"]) : null,
            planGrant: isset($data["plan_grant"]) ? SubscriptionPlanGrant::fromArray($data["plan_grant"]) : null,
            consumptionModel: isset($data["consumption_model"]) ? ConsumptionModel::from($data["consumption_model"]) : null,
            credits: isset($data["credits"]) ? SubscriptionCredits::fromArray($data["credits"]) : null,
            balance: isset($data["balance"]) ? SubscriptionBalance::fromArray($data["balance"]) : null,
            priceId: $data["price_id"] ?? null,
        );
    }
}
