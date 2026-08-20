<?php

declare(strict_types=1);

namespace Commet\Resources;

use Commet\HttpClient;
use Commet\Models\TestClock;
use Commet\Models\TestClockRun;

class TestClockResource
{
    public function __construct(
        private readonly HttpClient $http,
    ) {}

    /**
     * Deprecated. POST /test-clock now advances time and processes every due billing deadline in one durable run.
     * @return null
     * @deprecated
     */
    public function processBilling(
        ?string $idempotencyKey = null,
    ): mixed {
        return $this->http->post(
            "/test-clock/process-billing",
            idempotencyKey: $idempotencyKey,
        )->data;
    }

    /**
     * Returns the organization's current test clock state and latest durable run. Sandbox only.
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
     * Starts a durable run that moves the test clock forward and processes every billing deadline due before the target time. Poll GET /test-clock for progress and terminal results. Sandbox only.
     * @return TestClockRun
     */
    public function advance(
        ?int $advanceDays = null,
        ?string $frozenTime = null,
        ?string $idempotencyKey = null,
    ): TestClockRun {
        $response = $this->http->post(
            "/test-clock",
            HttpClient::buildBody([
                "advance_days" => $advanceDays,
                "frozen_time" => $frozenTime,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid TestClockRun response payload");
        }

        return TestClockRun::fromArray($response->data);
    }
}
