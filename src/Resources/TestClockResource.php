<?php

declare(strict_types=1);

namespace Commet\Resources;

use Commet\ApiResponse;
use Commet\HttpClient;
use Commet\Models\TestClock;
use Commet\Models\TestClockBilling;

class TestClockResource
{
    public function __construct(
        private readonly HttpClient $http,
    ) {}

    /**
     * Returns the organization's current test clock state. Sandbox only.
     * @return ApiResponse<TestClock>
     */
    public function get(

    ): ApiResponse {
        $response = $this->http->get(
            "/test-clock",
        );

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: TestClock::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }

    /**
     * Moves the test clock forward, by a number of days (advanceDays) or to an absolute instant (frozenTime). The clock can only move forward. Sandbox only.
     * @return ApiResponse<TestClock>
     */
    public function advance(
        ?int $advanceDays = null,
        ?string $frozenTime = null,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        $response = $this->http->post(
            "/test-clock",
            HttpClient::buildBody([
                "advance_days" => $advanceDays,
                "frozen_time" => $frozenTime,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: TestClock::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }

    /**
     * Discovers customers due for billing at the org's current (simulated) time and enqueues a billing cycle for each — renewals, expired trials, pending cancellations. Enqueueing is asynchronous. Sandbox only.
     * @return ApiResponse<TestClockBilling>
     */
    public function processBilling(
        ?string $idempotencyKey = null,
    ): ApiResponse {
        $response = $this->http->post(
            "/test-clock/process-billing",
            idempotencyKey: $idempotencyKey,
        );

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: TestClockBilling::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }
}
