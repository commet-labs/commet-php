<?php

declare(strict_types=1);

namespace Commet\Resources;

use Commet\ApiResponse;
use Commet\Enums\BillingInterval;
use Commet\Enums\DiscountType;
use Commet\Enums\SubscriptionStatus;
use Commet\HttpClient;
use Commet\Models\BalanceAdjustment;
use Commet\Models\BalanceTopup;
use Commet\Models\CanceledSubscription;
use Commet\Models\CreditGrant;
use Commet\Models\DeletedSubscriptionAddon;
use Commet\Models\PaymentMethodUpdateCheckout;
use Commet\Models\PlanChange;
use Commet\Models\PreviewChange;
use Commet\Models\ReactivatedSubscription;
use Commet\Models\RecoveryLink;
use Commet\Models\Subscription;
use Commet\Models\SubscriptionAddon;
use Commet\Models\UncanceledSubscription;

class SubscriptionsResource
{
    public function __construct(
        private readonly HttpClient $http,
    ) {}

    /**
     * List all subscriptions. Filter by customer ID or status.
     * @return ApiResponse<Subscription[]>
     */
    public function list(
        ?string $customerId = null,
        ?SubscriptionStatus $status = null,
    ): ApiResponse {
        $response = $this->http->get(
            "/subscriptions",
            HttpClient::buildBody([
                "customer_id" => $customerId,
                "status" => $status?->value,
            ]),
        );

        if ($response->success && is_array($response->data)) {
            $items = array_map(
                fn(array $item) => Subscription::fromArray($item),
                $response->data,
            );

            return new ApiResponse(
                success: true,
                data: $items,
                code: $response->code,
                message: $response->message,
                hasMore: $response->hasMore,
                nextCursor: $response->nextCursor,
            );
        }

        return $response;
    }

    /**
     * Create a subscription for a customer. Requires planId or planCode plus customerId.
     * @param array<string, int>|null $initialSeats
     * @param array<string, mixed>|null $introOffer
     * @return ApiResponse<Subscription>
     */
    public function create(
        string $customerId,
        ?string $planId = null,
        ?string $planCode = null,
        ?BillingInterval $billingInterval = null,
        ?array $initialSeats = null,
        ?bool $skipTrial = null,
        ?array $introOffer = null,
        ?string $name = null,
        ?string $startDate = null,
        ?string $successUrl = null,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        $response = $this->http->post(
            "/subscriptions",
            HttpClient::buildBody([
                "plan_id" => $planId,
                "plan_code" => $planCode,
                "customer_id" => $customerId,
                "billing_interval" => $billingInterval?->value,
                "initial_seats" => $initialSeats,
                "skip_trial" => $skipTrial,
                "intro_offer" => $introOffer,
                "name" => $name,
                "start_date" => $startDate,
                "success_url" => $successUrl,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: Subscription::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }

    /**
     * Get a subscription by its public ID, regardless of status (including pending_payment and past_due).
     * @return ApiResponse<Subscription>
     */
    public function get(
        string $id,
    ): ApiResponse {
        $response = $this->http->get(
            "/subscriptions/{$id}",
        );

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: Subscription::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }

    /**
     * Get the active subscription for a customer. Returns null if none.
     * @return ApiResponse<Subscription>
     */
    public function getActive(
        string $customerId,
    ): ApiResponse {
        $response = $this->http->get(
            "/subscriptions/active",
            HttpClient::buildBody([
                "customer_id" => $customerId,
            ]),
        );

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: Subscription::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }

    /**
     * Cancel immediately or at period end.
     * @return ApiResponse<CanceledSubscription>
     */
    public function cancel(
        string $id,
        ?string $reason = null,
        ?bool $immediate = null,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        $response = $this->http->post(
            "/subscriptions/{$id}/cancel",
            HttpClient::buildBody([
                "reason" => $reason,
                "immediate" => $immediate,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: CanceledSubscription::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }

    /**
     * Revert a scheduled cancellation. Only works when canceledAt is set but status is not yet 'canceled'.
     * @return ApiResponse<UncanceledSubscription>
     */
    public function uncancel(
        string $id,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        $response = $this->http->post(
            "/subscriptions/{$id}/uncancel",
            idempotencyKey: $idempotencyKey,
        );

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: UncanceledSubscription::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }

    /**
     * Reactivates a subscription. A past_due subscription retries its outstanding renewal charge (recovering to active on success). A canceled subscription generates a fresh invoice, charges the saved card, and resets the billing period. On a successful charge the subscription becomes active; a declined charge returns an error with a recoveryUrl in the error details that can be sent to the customer to update their card.
     * @return ApiResponse<ReactivatedSubscription>
     */
    public function reactivate(
        string $id,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        $response = $this->http->post(
            "/subscriptions/{$id}/reactivate",
            idempotencyKey: $idempotencyKey,
        );

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: ReactivatedSubscription::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }

    /**
     * Generates a hosted, signed recovery link that lets the customer pay the outstanding renewal charge for a past_due subscription. Unlike reactivate, which charges server-to-server, this returns a link the merchant can deliver through their own email, SMS, or dashboard. The link carries a self-contained signed token and stays valid until the charge is paid or the subscription is no longer past due.
     * @return ApiResponse<RecoveryLink>
     */
    public function createRecoveryLink(
        string $id,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        $response = $this->http->post(
            "/subscriptions/{$id}/recovery-link",
            idempotencyKey: $idempotencyKey,
        );

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: RecoveryLink::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }

    /**
     * Creates a hosted checkout session for the customer to update the subscription's default payment method.
     * @return ApiResponse<PaymentMethodUpdateCheckout>
     */
    public function updatePaymentMethod(
        string $id,
        ?string $successUrl = null,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        $response = $this->http->post(
            "/subscriptions/{$id}/payment-method/update",
            HttpClient::buildBody([
                "success_url" => $successUrl,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: PaymentMethodUpdateCheckout::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }

    /**
     * Upgrade, downgrade, or change billing interval.
     * @return ApiResponse<PlanChange>
     */
    public function changePlan(
        string $id,
        ?string $newPlanId = null,
        ?string $newBillingInterval = null,
        ?string $successUrl = null,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        $response = $this->http->post(
            "/subscriptions/{$id}/change-plan",
            HttpClient::buildBody([
                "new_plan_id" => $newPlanId,
                "new_billing_interval" => $newBillingInterval,
                "success_url" => $successUrl,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: PlanChange::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }

    /**
     * Preview proration details for an immediate plan change (an upgrade or a longer interval) without applying it. Returns credit, charge, and net amount. Downgrades — a cheaper plan in the same group, or a shorter interval — are scheduled for the end of the current period instead of being prorated, so they return a 400 with code `plan_change_scheduled`; apply those via the change-plan endpoint.
     * @return ApiResponse<PreviewChange>
     */
    public function previewChange(
        string $id,
        string $planId,
        ?BillingInterval $billingInterval = null,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        $response = $this->http->post(
            "/subscriptions/{$id}/preview-change",
            HttpClient::buildBody([
                "plan_id" => $planId,
                "billing_interval" => $billingInterval?->value,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: PreviewChange::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }

    /**
     * Activate an add-on on a subscription. Charges a prorated amount for the current billing period.
     * @return ApiResponse<SubscriptionAddon>
     */
    public function activateAddon(
        string $id,
        string $addonId,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        $response = $this->http->post(
            "/subscriptions/{$id}/addons",
            HttpClient::buildBody([
                "addon_id" => $addonId,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: SubscriptionAddon::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }

    /**
     * Deactivate an add-on from a subscription.
     * @return ApiResponse<DeletedSubscriptionAddon>
     */
    public function deactivateAddon(
        string $id,
        string $addonId,
    ): ApiResponse {
        $response = $this->http->delete(
            "/subscriptions/{$id}/addons/{$addonId}",
        );

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: DeletedSubscriptionAddon::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }

    /**
     * Adjust a subscription's balance or credits by a signed amount. Positive adds, negative subtracts.
     * @return ApiResponse<BalanceAdjustment>
     */
    public function adjustBalance(
        string $id,
        int $amount,
        ?string $reason = null,
        ?string $type = null,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        $response = $this->http->post(
            "/subscriptions/{$id}/balance/adjust",
            HttpClient::buildBody([
                "amount" => $amount,
                "reason" => $reason,
                "type" => $type,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: BalanceAdjustment::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }

    /**
     * Top up a subscription's balance. Charges the customer's payment method for the specified amount.
     * @return ApiResponse<BalanceTopup>
     */
    public function topupBalance(
        string $id,
        int $amount,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        $response = $this->http->post(
            "/subscriptions/{$id}/balance/topup",
            HttpClient::buildBody([
                "amount" => $amount,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: BalanceTopup::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }

    /**
     * Purchase a credit pack for a subscription. Charges the customer and adds credits to their balance.
     * @return ApiResponse<CreditGrant>
     */
    public function purchaseCredits(
        string $id,
        string $creditPackId,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        $response = $this->http->post(
            "/subscriptions/{$id}/credits",
            HttpClient::buildBody([
                "credit_pack_id" => $creditPackId,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: CreditGrant::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }
}
