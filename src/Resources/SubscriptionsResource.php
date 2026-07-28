<?php

declare(strict_types=1);

namespace Commet\Resources;

use Commet\Enums\SubscriptionStatus;
use Commet\HttpClient;
use Commet\Models\BalanceAdjustment;
use Commet\Models\BalanceTopup;
use Commet\Models\CreatedSubscription;
use Commet\Models\CreditGrant;
use Commet\Models\DeletedSubscriptionAddon;
use Commet\Models\PaymentMethodUpdateCheckout;
use Commet\Models\PlanChange;
use Commet\Models\PreviewChange;
use Commet\Models\ReactivatedSubscription;
use Commet\Models\RecoveryLink;
use Commet\Models\Subscription;
use Commet\Models\SubscriptionAddon;
use Commet\Models\SubscriptionsListResult;

class SubscriptionsResource
{
    public function __construct(
        private readonly HttpClient $http,
    ) {}

    /**
     * Deactivate an add-on from a subscription.
     * @return DeletedSubscriptionAddon
     */
    public function deactivateAddon(
        string $id,
        string $addonId,
    ): DeletedSubscriptionAddon {
        $response = $this->http->delete(
            "/subscriptions/{$id}/addons/{$addonId}",
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid DeletedSubscriptionAddon response payload");
        }

        return DeletedSubscriptionAddon::fromArray($response->data);
    }

    /**
     * Activate an add-on on a subscription. Charges a prorated amount for the current billing period.
     * @return SubscriptionAddon
     */
    public function activateAddon(
        string $id,
        string $addonId,
        ?string $idempotencyKey = null,
    ): SubscriptionAddon {
        $response = $this->http->post(
            "/subscriptions/{$id}/addons",
            HttpClient::buildBody([
                "addon_id" => $addonId,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid SubscriptionAddon response payload");
        }

        return SubscriptionAddon::fromArray($response->data);
    }

    /**
     * Adjust a subscription's balance or credits by a signed amount. Positive adds, negative subtracts.
     * @return BalanceAdjustment
     */
    public function adjustBalance(
        string $id,
        int $amount,
        ?string $reason = null,
        ?string $type = null,
        ?string $idempotencyKey = null,
    ): BalanceAdjustment {
        $response = $this->http->post(
            "/subscriptions/{$id}/balance/adjust",
            HttpClient::buildBody([
                "amount" => $amount,
                "reason" => $reason,
                "type" => $type,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid BalanceAdjustment response payload");
        }

        return BalanceAdjustment::fromArray($response->data);
    }

    /**
     * Top up a subscription's balance. Charges the customer's payment method for the specified amount.
     * @return BalanceTopup
     */
    public function topupBalance(
        string $id,
        int $amount,
        ?string $idempotencyKey = null,
    ): BalanceTopup {
        $response = $this->http->post(
            "/subscriptions/{$id}/balance/topup",
            HttpClient::buildBody([
                "amount" => $amount,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid BalanceTopup response payload");
        }

        return BalanceTopup::fromArray($response->data);
    }

    /**
     * Cancel immediately or at period end and return the updated subscription.
     * @return Subscription
     */
    public function cancel(
        string $id,
        ?string $reason = null,
        ?bool $immediate = null,
        ?string $idempotencyKey = null,
    ): Subscription {
        $response = $this->http->post(
            "/subscriptions/{$id}/cancel",
            HttpClient::buildBody([
                "reason" => $reason,
                "immediate" => $immediate,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid Subscription response payload");
        }

        return Subscription::fromArray($response->data);
    }

    /**
     * Upgrade or change billing interval immediately, optionally applying a quoted Promotional Offer. Scheduled changes do not accept offers.
     * @return PlanChange
     */
    public function changePlan(
        string $id,
        ?string $newPlanId = null,
        ?string $newBillingInterval = null,
        ?string $successUrl = null,
        ?string $offerId = null,
        ?string $idempotencyKey = null,
    ): PlanChange {
        $response = $this->http->post(
            "/subscriptions/{$id}/change-plan",
            HttpClient::buildBody([
                "new_plan_id" => $newPlanId,
                "new_billing_interval" => $newBillingInterval,
                "success_url" => $successUrl,
                "offer_id" => $offerId,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid PlanChange response payload");
        }

        return PlanChange::fromArray($response->data);
    }

    /**
     * Purchase a credit pack for a subscription. Charges the customer and adds credits to their balance.
     * @return CreditGrant
     */
    public function purchaseCredits(
        string $id,
        string $creditPackId,
        ?string $idempotencyKey = null,
    ): CreditGrant {
        $response = $this->http->post(
            "/subscriptions/{$id}/credits",
            HttpClient::buildBody([
                "credit_pack_id" => $creditPackId,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid CreditGrant response payload");
        }

        return CreditGrant::fromArray($response->data);
    }

    /**
     * Creates a hosted checkout session for the customer to update the subscription's default payment method.
     * @return PaymentMethodUpdateCheckout
     */
    public function updatePaymentMethod(
        string $id,
        ?string $successUrl = null,
        ?string $idempotencyKey = null,
    ): PaymentMethodUpdateCheckout {
        $response = $this->http->post(
            "/subscriptions/{$id}/payment-method/update",
            HttpClient::buildBody([
                "success_url" => $successUrl,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid PaymentMethodUpdateCheckout response payload");
        }

        return PaymentMethodUpdateCheckout::fromArray($response->data);
    }

    /**
     * Preview proration details for an immediate plan change (an upgrade or a longer interval) without applying it. Returns credit, charge, and net amount. The target plan must belong to the same plan group as the current plan, otherwise a 400 with code `plans_not_in_same_group` is returned. A change between two free plans has nothing to prorate and returns a zero-amount estimate. Downgrades — a cheaper plan in the same group, or a shorter interval — are scheduled for the end of the current period instead of being prorated, so they return a 400 with code `plan_change_scheduled`; apply those via the change-plan endpoint. Pass offerId to quote the destination plan with a Promotional Offer.
     * @return PreviewChange
     */
    public function previewChange(
        string $id,
        string $planId,
        ?string $billingInterval = null,
        ?string $offerId = null,
        ?string $idempotencyKey = null,
    ): PreviewChange {
        $response = $this->http->post(
            "/subscriptions/{$id}/preview-change",
            HttpClient::buildBody([
                "plan_id" => $planId,
                "billing_interval" => $billingInterval,
                "offer_id" => $offerId,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid PreviewChange response payload");
        }

        return PreviewChange::fromArray($response->data);
    }

    /**
     * Reactivates a subscription. A past_due subscription retries its outstanding renewal charge (recovering to active on success). A canceled subscription generates a fresh invoice, charges the saved card, and resets the billing period. On a successful charge the subscription becomes active; a declined charge returns an error with a recoveryUrl in the error details that can be sent to the customer to update their card. A canceled subscription may apply a Promotional Offer by offerId; past-due recovery cannot.
     * @return ReactivatedSubscription
     */
    public function reactivate(
        string $id,
        ?string $offerId = null,
        ?string $idempotencyKey = null,
    ): ReactivatedSubscription {
        $response = $this->http->post(
            "/subscriptions/{$id}/reactivate",
            HttpClient::buildBody([
                "offer_id" => $offerId,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid ReactivatedSubscription response payload");
        }

        return ReactivatedSubscription::fromArray($response->data);
    }

    /**
     * Generates a hosted, signed recovery link that lets the customer pay the outstanding renewal charge for a past_due subscription. Unlike reactivate, which charges server-to-server, this returns a link the merchant can deliver through their own email, SMS, or dashboard. The link carries a self-contained signed token and stays valid until the charge is paid or the subscription is no longer past due.
     * @return RecoveryLink
     */
    public function createRecoveryLink(
        string $id,
        ?string $idempotencyKey = null,
    ): RecoveryLink {
        $response = $this->http->post(
            "/subscriptions/{$id}/recovery-links",
            idempotencyKey: $idempotencyKey,
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid RecoveryLink response payload");
        }

        return RecoveryLink::fromArray($response->data);
    }

    /**
     * Get a subscription by its public ID, regardless of status (including pending_payment and past_due).
     * @return Subscription
     */
    public function get(
        string $id,
    ): Subscription {
        $response = $this->http->get(
            "/subscriptions/{$id}",
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid Subscription response payload");
        }

        return Subscription::fromArray($response->data);
    }

    /**
     * Revert a scheduled cancellation and return the updated subscription. Only works before cancellation takes effect.
     * @return Subscription
     */
    public function uncancel(
        string $id,
        ?string $idempotencyKey = null,
    ): Subscription {
        $response = $this->http->post(
            "/subscriptions/{$id}/uncancel",
            idempotencyKey: $idempotencyKey,
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid Subscription response payload");
        }

        return Subscription::fromArray($response->data);
    }

    /**
     * Get the active subscription for a customer. Returns null if none.
     * @return Subscription|null
     */
    public function getActive(
        string $customerId,
    ): ?Subscription {
        $response = $this->http->get(
            "/subscriptions/active",
            HttpClient::buildBody([
                "customer_id" => $customerId,
            ]),
        );

        if ($response->data === null) {
            return null;
        }

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid Subscription response payload");
        }

        return Subscription::fromArray($response->data);
    }

    /**
     * List all subscriptions. Filter by customer ID or status.
     * @return SubscriptionsListResult
     */
    public function list(
        ?string $customerId = null,
        ?SubscriptionStatus $status = null,
    ): SubscriptionsListResult {
        $response = $this->http->get(
            "/subscriptions",
            HttpClient::buildBody([
                "customer_id" => $customerId,
                "status" => $status?->value,
            ]),
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid SubscriptionsListResult response payload");
        }

        return SubscriptionsListResult::fromArray($response->data);
    }

    /**
     * Create a subscription for a customer. Commet selects the default price when priceId is omitted and resolves its market from the customer's billing country. Without an offer override, Commet applies the price's automatic introductory offer. Pass one Promotional Offer through offerId to override it. Experiment assignment remains external.
     * @param array<string, int>|null $initialSeats
     * @return CreatedSubscription
     */
    public function create(
        string $customerId,
        ?string $billingInterval = null,
        ?string $priceId = null,
        ?array $initialSeats = null,
        ?string $provider = null,
        ?string $name = null,
        ?string $startDate = null,
        ?string $successUrl = null,
        ?string $offerId = null,
        ?string $promoCode = null,
        ?int $customTrialDays = null,
        ?bool $skipTrial = null,
        ?string $planId = null,
        ?string $planCode = null,
        ?string $idempotencyKey = null,
    ): CreatedSubscription {
        $response = $this->http->post(
            "/subscriptions",
            HttpClient::buildBody([
                "customer_id" => $customerId,
                "billing_interval" => $billingInterval,
                "price_id" => $priceId,
                "initial_seats" => $initialSeats,
                "provider" => $provider,
                "name" => $name,
                "start_date" => $startDate,
                "success_url" => $successUrl,
                "offer_id" => $offerId,
                "promo_code" => $promoCode,
                "custom_trial_days" => $customTrialDays,
                "skip_trial" => $skipTrial,
                "plan_id" => $planId,
                "plan_code" => $planCode,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid CreatedSubscription response payload");
        }

        return CreatedSubscription::fromArray($response->data);
    }
}
