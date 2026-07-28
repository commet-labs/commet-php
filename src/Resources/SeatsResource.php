<?php

declare(strict_types=1);

namespace Commet\Resources;

use Commet\HttpClient;
use Commet\Models\SeatBalance;
use Commet\Models\SeatBalanceCollection;
use Commet\Models\SeatEvent;
use Commet\Models\SeatsSetAllResult;

class SeatsResource
{
    public function __construct(
        private readonly HttpClient $http,
    ) {}

    /**
     * Get current balance for a specific seat type.
     * @return SeatBalance
     */
    public function getBalance(
        string $customerId,
        string $featureCode,
    ): SeatBalance {
        $response = $this->http->get(
            "/seats/balance",
            HttpClient::buildBody([
                "customer_id" => $customerId,
                "feature_code" => $featureCode,
            ]),
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid SeatBalance response payload");
        }

        return SeatBalance::fromArray($response->data);
    }

    /**
     * Get the current balance for all seat types in a customer's subscription.
     * @return SeatBalanceCollection
     */
    public function getAllBalances(
        string $customerId,
    ): SeatBalanceCollection {
        $response = $this->http->get(
            "/seats/balances",
            HttpClient::buildBody([
                "customer_id" => $customerId,
            ]),
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid SeatBalanceCollection response payload");
        }

        return SeatBalanceCollection::fromArray($response->data);
    }

    /**
     * Set all seat types at once.
     * @param array<string, int> $seats
     * @return SeatsSetAllResult
     */
    public function setAll(
        string $customerId,
        array $seats,
        ?string $idempotencyKey = null,
    ): SeatsSetAllResult {
        $response = $this->http->put(
            "/seats/bulk",
            HttpClient::buildBody([
                "customer_id" => $customerId,
                "seats" => $seats,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid SeatsSetAllResult response payload");
        }

        return SeatsSetAllResult::fromArray($response->data);
    }

    /**
     * Remove seats from a customer's subscription. Takes effect at the end of the billing period.
     * @return SeatEvent
     */
    public function remove(
        string $customerId,
        string $featureCode,
        int $count,
        ?string $idempotencyKey = null,
    ): SeatEvent {
        $response = $this->http->post(
            "/seats/remove",
            HttpClient::buildBody([
                "customer_id" => $customerId,
                "feature_code" => $featureCode,
                "count" => $count,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid SeatEvent response payload");
        }

        return SeatEvent::fromArray($response->data);
    }

    /**
     * Add seats to a customer's subscription. Prorates charges for the current billing period.
     * @return SeatEvent
     */
    public function add(
        string $customerId,
        string $featureCode,
        int $count,
        ?string $idempotencyKey = null,
    ): SeatEvent {
        $response = $this->http->post(
            "/seats",
            HttpClient::buildBody([
                "customer_id" => $customerId,
                "feature_code" => $featureCode,
                "count" => $count,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid SeatEvent response payload");
        }

        return SeatEvent::fromArray($response->data);
    }

    /**
     * Set seats to an exact count.
     * @return SeatEvent
     */
    public function set(
        string $customerId,
        string $featureCode,
        int $count,
        ?string $idempotencyKey = null,
    ): SeatEvent {
        $response = $this->http->put(
            "/seats",
            HttpClient::buildBody([
                "customer_id" => $customerId,
                "feature_code" => $featureCode,
                "count" => $count,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid SeatEvent response payload");
        }

        return SeatEvent::fromArray($response->data);
    }
}
