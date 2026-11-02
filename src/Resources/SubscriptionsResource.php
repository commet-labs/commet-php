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
use Commet\Models\PrepaidPeriodsCheckout;
use Commet\Models\PreviewChange;
use Commet\Models\ReactivatedSubscription;
use Commet\Models\RecoveryLink;
use Commet\Models\Subscription;
use Commet\Models\SubscriptionAddon;
use Commet\Models\SubscriptionAutoTopUp;
use Commet\Models\SubscriptionResume;
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
     * Read whether the subscription buys credits automatically with its saved payment method when credits reach a threshold, with the top-ups used this period and the last failure.
     * @return SubscriptionAutoTopUp
     */
    public function getAutoTopUp(
        string $id,
    ): SubscriptionAutoTopUp {
        $response = $this->http->get(
            "/subscriptions/{$id}/auto-top-up",
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid SubscriptionAutoTopUp response payload");
        }

        return SubscriptionAutoTopUp::fromArray($response->data);
    }

    /**
     * Turn automatic credit purchases on or off and set the threshold, the credits each top-up buys and the maximum top-ups per period. Send only the fields that change. Enabling requires a plan that sells credits. The quantity must be at least the plan's purchase minimum when auto top-up is enabled or when the quantity changes, so turning it off keeps working after the minimum rises. Saving it enabled resumes a paused auto top-up.
     * @return SubscriptionAutoTopUp
     */
    public function updateAutoTopUp(
        string $id,
        ?bool $enabled = null,
        ?int $threshold = null,
        ?int $quantity = null,
        ?int $maxPerPeriod = null,
        ?string $idempotencyKey = null,
    ): SubscriptionAutoTopUp {
        $response = $this->http->patch(
            "/subscriptions/{$id}/auto-top-up",
            HttpClient::buildBody([
                "enabled" => $enabled,
                "threshold" => $threshold,
                "quantity" => $quantity,
                "max_per_period" => $maxPerPeriod,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid SubscriptionAutoTopUp response payload");
        }

        return SubscriptionAutoTopUp::fromArray($response->data);
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
     * Upgrade or change billing interval immediately, optionally applying an Offer by offerId or the Offer of a promoCode. Scheduled changes accept neither offerId nor promoCode. From a free plan, a promoCode opens the checkout with the code applied and counts its use when the checkout is paid; without offerId or promoCode, a destination price whose free trial requires no payment method starts that trial right away without checkout. During a trial without a payment method, an immediate change returns 409 no_payment_method; scheduled changes still apply.
     * @return PlanChange
     */
    public function changePlan(
        string $id,
        ?string $newPlanId = null,
        ?string $newBillingInterval = null,
        ?string $successUrl = null,
        ?string $offerId = null,
        ?string $promoCode = null,
        ?string $idempotencyKey = null,
    ): PlanChange {
        $response = $this->http->post(
            "/subscriptions/{$id}/change-plan",
            HttpClient::buildBody([
                "new_plan_id" => $newPlanId,
                "new_billing_interval" => $newBillingInterval,
                "success_url" => $successUrl,
                "offer_id" => $offerId,
                "promo_code" => $promoCode,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid PlanChange response payload");
        }

        return PlanChange::fromArray($response->data);
    }

    /**
     * Purchase a fixed credit pack or choose a whole credit quantity at the subscription plan price and minimum. Charges the saved payment method and adds purchased credits.
     * @return CreditGrant
     */
    public function purchaseCredits(
        string $id,
        ?string $creditPackId = null,
        ?int $quantity = null,
        ?string $idempotencyKey = null,
    ): CreditGrant {
        $response = $this->http->post(
            "/subscriptions/{$id}/credits",
            HttpClient::buildBody([
                "credit_pack_id" => $creditPackId,
                "quantity" => $quantity,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid CreditGrant response payload");
        }

        return CreditGrant::fromArray($response->data);
    }

    /**
     * Apply a direct Offer to a subscription. On a pending checkout it quotes or replaces the checkout discount, which starts after the plan price trial when there is one, and the existing checkout URL remains unchanged. On an active subscription it applies the Offer immediately with its discount phases starting at the next billing cycle; the call is rejected while another applied Offer still has active or upcoming discount phases.
     * @return Subscription
     */
    public function applyOffer(
        string $id,
        string $offerId,
        ?string $expiresAt = null,
        ?string $idempotencyKey = null,
    ): Subscription {
        $response = $this->http->put(
            "/subscriptions/{$id}/offer",
            HttpClient::buildBody([
                "offer_id" => $offerId,
                "expires_at" => $expiresAt,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid Subscription response payload");
        }

        return Subscription::fromArray($response->data);
    }

    /**
     * Remove the quoted direct Offer from a subscription's pending payment checkout. The existing checkout URL remains unchanged and returns to its undiscounted price.
     * @return Subscription
     */
    public function removeOffer(
        string $id,
    ): Subscription {
        $response = $this->http->delete(
            "/subscriptions/{$id}/offer",
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid Subscription response payload");
        }

        return Subscription::fromArray($response->data);
    }

    /**
     * Pause immediately or schedule a pause for the end of the current billing or trial period. Set durationDays to null for an indefinite pause.
     * @return Subscription
     */
    public function pause(
        string $id,
        string $mode,
        ?int $durationDays,
        ?string $idempotencyKey = null,
    ): Subscription {
        $response = $this->http->post(
            "/subscriptions/{$id}/pause",
            HttpClient::buildBody([
                "mode" => $mode,
            ]) + [
                "duration_days" => $durationDays,
            ],
            idempotencyKey: $idempotencyKey,
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid Subscription response payload");
        }

        return Subscription::fromArray($response->data);
    }

    /**
     * Change the duration of a scheduled or active pause. Set durationDays to null to make it indefinite.
     * @return Subscription
     */
    public function updatePause(
        string $id,
        ?int $durationDays,
        ?string $idempotencyKey = null,
    ): Subscription {
        $response = $this->http->patch(
            "/subscriptions/{$id}/pause",
            HttpClient::buildBody([

            ]) + [
                "duration_days" => $durationDays,
            ],
            idempotencyKey: $idempotencyKey,
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid Subscription response payload");
        }

        return Subscription::fromArray($response->data);
    }

    /**
     * Revoke a pause before it becomes effective. Active pauses must be resumed instead.
     * @return Subscription
     */
    public function revokePause(
        string $id,
    ): Subscription {
        $response = $this->http->delete(
            "/subscriptions/{$id}/pause",
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid Subscription response payload");
        }

        return Subscription::fromArray($response->data);
    }

    /**
     * Creates a hosted checkout to update the payment method of an active, trialing or past_due subscription. Pending-payment subscriptions must use their payment checkout.
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
     * Creates a hosted checkout to pay billing periods of a recurring subscription in advance with any payment method. On an active subscription the paid periods start after the last paid period and replace any open prepaid-periods checkout. On a pending-payment subscription the first payment covers the requested periods and replaces its pending checkout. The billing interval does not change.
     * @return PrepaidPeriodsCheckout
     */
    public function createPrepaidPeriodsCheckout(
        string $id,
        int $periods,
        ?string $offerId = null,
        ?string $successUrl = null,
        ?string $idempotencyKey = null,
    ): PrepaidPeriodsCheckout {
        $response = $this->http->post(
            "/subscriptions/{$id}/prepaid-periods",
            HttpClient::buildBody([
                "periods" => $periods,
                "offer_id" => $offerId,
                "success_url" => $successUrl,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid PrepaidPeriodsCheckout response payload");
        }

        return PrepaidPeriodsCheckout::fromArray($response->data);
    }

    /**
     * Preview proration details for an immediate plan change without applying it. Free-to-paid changes are never scheduled and the change-plan endpoint returns hosted checkout for them, except a change without offerId or promoCode to a price whose free trial needs no payment method, for a customer who never had that plan: it starts the trial at once, so the preview reports nothing due today. For paid plans, interval direction takes precedence: a longer interval is immediate and a shorter interval is scheduled. When the interval is unchanged, a higher-sort-order plan is immediate and a lower-sort-order plan is scheduled. A paid-to-free change is always scheduled. Returns credit, charge, and net amount. The target plan must belong to the same plan group as the current plan, otherwise a 400 with code `plans_not_in_same_group` is returned. A change between two free plans has nothing to prorate and returns a zero-amount estimate. Scheduled changes return a 400 with code `plan_change_scheduled`; apply those via the change-plan endpoint. Pass offerId to quote the destination plan with an Offer, or promoCode to quote it with the Offer of a promo code validated with the checkout's rules.
     * @return PreviewChange
     */
    public function previewChange(
        string $id,
        string $planId,
        ?string $billingInterval = null,
        ?string $offerId = null,
        ?string $promoCode = null,
        ?string $idempotencyKey = null,
    ): PreviewChange {
        $response = $this->http->post(
            "/subscriptions/{$id}/preview-change",
            HttpClient::buildBody([
                "plan_id" => $planId,
                "billing_interval" => $billingInterval,
                "offer_id" => $offerId,
                "promo_code" => $promoCode,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid PreviewChange response payload");
        }

        return PreviewChange::fromArray($response->data);
    }

    /**
     * Reactivates a subscription. A past_due subscription retries its outstanding renewal charge (recovering to active on success). A canceled subscription generates a fresh invoice, charges the saved card, and resets the billing period. On a successful charge the subscription becomes active; a declined charge returns an error with a recoveryUrl in the error details that can be sent to the customer to update their card. A canceled subscription may apply an Offer by offerId; past-due recovery cannot.
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
     * Resume a paused subscription. Immediate pauses continue the preserved period without a charge. Period-end pauses charge a new period before access is restored.
     * @return SubscriptionResume
     */
    public function resume(
        string $id,
        ?string $idempotencyKey = null,
    ): SubscriptionResume {
        $response = $this->http->post(
            "/subscriptions/{$id}/resume",
            idempotencyKey: $idempotencyKey,
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid SubscriptionResume response payload");
        }

        return SubscriptionResume::fromArray($response->data);
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
     * Revoke the plan or interval change scheduled for the end of the period, so the subscription stays on its current plan. Returns the updated subscription.
     * @return Subscription
     */
    public function revokeScheduledPlanChange(
        string $id,
    ): Subscription {
        $response = $this->http->delete(
            "/subscriptions/{$id}/scheduled-plan-change",
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
     * Create a subscription for a customer. Commet selects the default price when priceId is omitted. The subscription starts at the base USD price; market and currency are resolved from the buyer's request country when the checkout opens. Without an offer override, Commet applies the price's automatic introductory Offer. Pass offerId to apply an active compatible Offer directly, or cardPromotionId to preselect a card-eligible Promotional Offer for the initial checkout when card promotions are enabled for the organization. For the initial checkout, provider accepts either a processor name or an exact payment connection ID. When the price's free trial requires no payment method, the subscription starts trialing right away with no checkout (checkoutUrl null, hasPaymentMethod false); it cannot be combined with offerId, promoCode, cardPromotionId or provider, and an organization that cannot charge yet receives 403.
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
        ?int $prepaidPeriods = null,
        ?bool $cancelAtPeriodEnd = null,
        ?string $offerId = null,
        ?string $promoCode = null,
        ?int $customTrialDays = null,
        ?bool $skipTrial = null,
        ?string $planId = null,
        ?string $planCode = null,
        ?string $cardPromotionId = null,
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
                "prepaid_periods" => $prepaidPeriods,
                "cancel_at_period_end" => $cancelAtPeriodEnd,
                "offer_id" => $offerId,
                "promo_code" => $promoCode,
                "custom_trial_days" => $customTrialDays,
                "skip_trial" => $skipTrial,
                "plan_id" => $planId,
                "plan_code" => $planCode,
                "card_promotion_id" => $cardPromotionId,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid CreatedSubscription response payload");
        }

        return CreatedSubscription::fromArray($response->data);
    }
}
