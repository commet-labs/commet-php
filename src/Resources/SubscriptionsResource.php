<?php

declare(strict_types=1);

namespace Commet\Resources;

use Commet\ApiResponse;
use Commet\HttpClient;

class SubscriptionsResource
{
    public function __construct(
        private readonly HttpClient $http,
    ) {}

    /**
     * @param array<string, int>|null $initialSeats
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
        return $this->http->post(
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
    }

    public function get(string $customerId): ApiResponse
    {
        return $this->http->get('/subscriptions/active', ['customer_id' => $customerId]);
    }

    public function cancel(
        string $subscriptionId,
        ?string $reason = null,
        ?bool $immediate = null,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        return $this->http->post(
            "/subscriptions/{$subscriptionId}/cancel",
            HttpClient::buildBody([
                'reason' => $reason,
                'immediate' => $immediate,
            ]),
            idempotencyKey: $idempotencyKey,
        );
    }
}
