<?php

declare(strict_types=1);

namespace Commet\Resources;

use Commet\ApiResponse;
use Commet\HttpClient;

class SeatsResource
{
    public function __construct(
        private readonly HttpClient $http,
    ) {}

    public function add(
        string $seatType,
        int $count,
        ?string $customerId = null,
        ?string $externalId = null,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        return $this->http->post(
            '/seats',
            HttpClient::buildBody([
                'seat_type' => $seatType,
                'count' => $count,
                'customer_id' => $customerId,
                'external_id' => $externalId,
            ]),
            idempotencyKey: $idempotencyKey,
        );
    }

    public function remove(
        string $seatType,
        int $count,
        ?string $customerId = null,
        ?string $externalId = null,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        return $this->http->delete(
            '/seats',
            HttpClient::buildBody([
                'seat_type' => $seatType,
                'count' => $count,
                'customer_id' => $customerId,
                'external_id' => $externalId,
            ]),
            idempotencyKey: $idempotencyKey,
        );
    }

    public function set(
        string $seatType,
        int $count,
        ?string $customerId = null,
        ?string $externalId = null,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        return $this->http->put(
            '/seats',
            HttpClient::buildBody([
                'seat_type' => $seatType,
                'count' => $count,
                'customer_id' => $customerId,
                'external_id' => $externalId,
            ]),
            idempotencyKey: $idempotencyKey,
        );
    }

    /**
     * @param array<string, int> $seats
     */
    public function setAll(
        array $seats,
        ?string $customerId = null,
        ?string $externalId = null,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        return $this->http->put(
            '/seats/bulk',
            HttpClient::buildBody([
                'seats' => $seats,
                'customer_id' => $customerId,
                'external_id' => $externalId,
            ]),
            idempotencyKey: $idempotencyKey,
        );
    }

    public function getBalance(
        string $seatType,
        ?string $customerId = null,
        ?string $externalId = null,
    ): ApiResponse {
        return $this->http->get(
            '/seats/balance',
            HttpClient::buildBody([
                'seat_type' => $seatType,
                'customer_id' => $customerId,
                'external_id' => $externalId,
            ]),
        );
    }

    public function getAllBalances(
        ?string $customerId = null,
        ?string $externalId = null,
    ): ApiResponse {
        return $this->http->get(
            '/seats/balances',
            HttpClient::buildBody([
                'customer_id' => $customerId,
                'external_id' => $externalId,
            ]),
        );
    }
}
