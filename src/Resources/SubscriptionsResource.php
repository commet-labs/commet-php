<?php

declare(strict_types=1);

namespace Commet\Resources;

use Commet\ApiResponse;
use Commet\HttpClient;
use Commet\Models\ActivateAddonResult;
use Commet\Models\DeactivateAddonResult;
use Commet\Models\Subscription;

class SubscriptionsResource
{
    public function __construct(
        private readonly HttpClient $http,
    ) {}

    /**
     * @param array<string, int>|null $initialSeats
     * @param array{discount_type: string, discount_value: int, duration_cycles: int}|null $customIntroOffer
     * @return ApiResponse<Subscription>
     */
    public function create(
        ?string $customerId = null,
        ?string $planCode = null,
        ?string $planId = null,
        ?string $billingInterval = null,
        ?array $initialSeats = null,
        ?bool $skipTrial = null,
        ?string $name = null,
        ?string $startDate = null,
        ?string $successUrl = null,
        ?array $customIntroOffer = null,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        $response = $this->http->post(
            '/subscriptions',
            HttpClient::buildBody([
                'customer_id' => $customerId,
                'plan_code' => $planCode,
                'plan_id' => $planId,
                'billing_interval' => $billingInterval,
                'initial_seats' => $initialSeats,
                'skip_trial' => $skipTrial,
                'name' => $name,
                'start_date' => $startDate,
                'success_url' => $successUrl,
                'custom_intro_offer' => $customIntroOffer,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        return self::toTyped($response);
    }

    /**
     * @return ApiResponse<Subscription|null>
     */
    public function getActive(string $customerId): ApiResponse
    {
        $response = $this->http->get('/subscriptions/active', ['customer_id' => $customerId]);

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
     * @return ApiResponse<Subscription[]>
     */
    public function list(
        ?string $customerId = null,
        ?string $status = null,
        ?int $limit = null,
        ?string $cursor = null,
    ): ApiResponse {
        $response = $this->http->get(
            '/subscriptions',
            HttpClient::buildBody([
                'customer_id' => $customerId,
                'status' => $status,
                'limit' => $limit,
                'cursor' => $cursor,
            ]),
        );

        if ($response->success && is_array($response->data)) {
            $subscriptions = array_map(
                fn(array $item) => Subscription::fromArray($item),
                $response->data,
            );

            return new ApiResponse(
                success: true,
                data: $subscriptions,
                code: $response->code,
                message: $response->message,
                hasMore: $response->hasMore,
                nextCursor: $response->nextCursor,
            );
        }

        return $response;
    }

    /**
     * @return ApiResponse<Subscription>
     */
    public function cancel(
        string $subscriptionId,
        ?string $reason = null,
        ?bool $immediate = null,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        $response = $this->http->post(
            "/subscriptions/{$subscriptionId}/cancel",
            HttpClient::buildBody([
                'reason' => $reason,
                'immediate' => $immediate,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        return self::toTyped($response);
    }

    /**
     * @return ApiResponse<Subscription>
     */
    public function uncancel(
        string $subscriptionId,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        $response = $this->http->post(
            "/subscriptions/{$subscriptionId}/uncancel",
            [],
            idempotencyKey: $idempotencyKey,
        );

        return self::toTyped($response);
    }

    /**
     * @return ApiResponse<array<string, mixed>>
     */
    public function changePlan(
        string $subscriptionId,
        ?string $newPlanId = null,
        ?string $newBillingInterval = null,
        ?string $successUrl = null,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        return $this->http->post(
            "/subscriptions/{$subscriptionId}/change-plan",
            HttpClient::buildBody([
                'new_plan_id' => $newPlanId,
                'new_billing_interval' => $newBillingInterval,
                'success_url' => $successUrl,
            ]),
            idempotencyKey: $idempotencyKey,
        );
    }

    /**
     * @return ApiResponse<array{current_plan_credit: int, new_plan_charge: int, estimated_total: int, effective_date: string, days_remaining: int, total_days: int, is_upgrade: bool}>
     */
    public function previewChange(
        string $subscriptionId,
        ?string $planId = null,
        ?string $billingInterval = null,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        return $this->http->post(
            "/subscriptions/{$subscriptionId}/preview-change",
            HttpClient::buildBody([
                'plan_id' => $planId,
                'billing_interval' => $billingInterval,
            ]),
            idempotencyKey: $idempotencyKey,
        );
    }

    /**
     * Prorated charge for the current billing period.
     *
     * @return ApiResponse<ActivateAddonResult>
     */
    public function activateAddon(
        string $subscriptionId,
        string $addonId,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        $response = $this->http->post(
            "/subscriptions/{$subscriptionId}/addons",
            ['addon_id' => $addonId],
            idempotencyKey: $idempotencyKey,
        );

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: ActivateAddonResult::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }

    /**
     * @return ApiResponse<DeactivateAddonResult>
     */
    public function deactivateAddon(
        string $subscriptionId,
        string $addonId,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        $response = $this->http->delete(
            "/subscriptions/{$subscriptionId}/addons/{$addonId}",
            idempotencyKey: $idempotencyKey,
        );

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: DeactivateAddonResult::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }

    /**
     * @return ApiResponse<array{amount: int, new_balance: int, reason: string|null}>
     */
    public function adjustBalance(
        string $subscriptionId,
        int $amount,
        ?string $reason = null,
        ?string $type = null,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        return $this->http->post(
            "/subscriptions/{$subscriptionId}/balance/adjust",
            HttpClient::buildBody([
                'amount' => $amount,
                'reason' => $reason,
                'type' => $type,
            ]),
            idempotencyKey: $idempotencyKey,
        );
    }

    /**
     * @return ApiResponse<array{amount: int}>
     */
    public function topupBalance(
        string $subscriptionId,
        int $amount,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        return $this->http->post(
            "/subscriptions/{$subscriptionId}/balance/topup",
            ['amount' => $amount],
            idempotencyKey: $idempotencyKey,
        );
    }

    /**
     * @return ApiResponse<array{credits: int}>
     */
    public function purchaseCredits(
        string $subscriptionId,
        string $creditPackId,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        return $this->http->post(
            "/subscriptions/{$subscriptionId}/credits",
            ['credit_pack_id' => $creditPackId],
            idempotencyKey: $idempotencyKey,
        );
    }

    /**
     * @return ApiResponse<Subscription>
     */
    private static function toTyped(ApiResponse $response): ApiResponse
    {
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
}
