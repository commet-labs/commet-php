<?php

declare(strict_types=1);

namespace Commet\Resources;

use Commet\HttpClient;
use Commet\Models\TestClock;
use Commet\Models\TestClockBilling;

class TestClockResource
{
    public function __construct(
        private readonly HttpClient $http,
    ) {}

    /**
     * Discovers customers due for billing at the org's current (simulated) time and enqueues a billing cycle for each — renewals, expired trials, pending cancellations. Also fires any dunning retry whose scheduled time has passed. Enqueueing is asynchronous. Sandbox only.
     * @return TestClockBilling
     */
    public function processBilling(
        ?string $idempotencyKey = null,
    ): TestClockBilling {
        $response = $this->http->post(
            "/test-clock/process-billing",
            idempotencyKey: $idempotencyKey,
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid TestClockBilling response payload");
        }

        return TestClockBilling::fromArray($response->data);
    }

    /**
     * Returns the organization's current test clock state. Sandbox only.
     * @return TestClock
     */
    public function get(

    ): TestClock {
        $response = $this->http->get(
            "/test-clock",
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid TestClock response payload");
        }

        return TestClock::fromArray($response->data);
    }

    /**
     * Moves the test clock forward, by a number of days (advanceDays) or to an absolute instant (frozenTime). The clock can only move forward. Sandbox only.
     * @return TestClock
     */
    public function advance(
        ?int $advanceDays = null,
        ?string $frozenTime = null,
        ?string $idempotencyKey = null,
    ): TestClock {
        $response = $this->http->post(
            "/test-clock",
            HttpClient::buildBody([
                "advance_days" => $advanceDays,
                "frozen_time" => $frozenTime,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid TestClock response payload");
        }

        return TestClock::fromArray($response->data);
    }
}
