<?php

declare(strict_types=1);

namespace Commet\Resources;

use Commet\ApiResponse;
use Commet\HttpClient;
use Commet\Models\Subscription;

class SubscriptionsResource
{
    public function __construct(
        private readonly HttpClient $http,
    ) {}

    /**
     * @param array<string, int>|null $initialSeats
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
            ]),
            idempotencyKey: $idempotencyKey,
        );

        return self::toTyped($response);
    }

    /**
     * @return ApiResponse<Subscription|null>
     */
    public function get(string $customerId): ApiResponse
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
