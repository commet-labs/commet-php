<?php

declare(strict_types=1);

namespace Commet\Resources;

use Commet\ApiResponse;
use Commet\HttpClient;
use Commet\Models\SeatBalance;
use Commet\Models\SeatEvent;

class SeatsResource
{
    public function __construct(
        private readonly HttpClient $http,
    ) {}

    /**
     * @return ApiResponse<SeatEvent>
     */
    public function add(
        string $featureCode,
        int $count = 1,
        ?string $customerId = null,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        $response = $this->http->post(
            '/seats',
            HttpClient::buildBody([
                'feature_code' => $featureCode,
                'count' => $count,
                'customer_id' => $customerId,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        return self::toTypedEvent($response);
    }

    /**
     * @return ApiResponse<SeatEvent>
     */
    public function remove(
        string $featureCode,
        int $count = 1,
        ?string $customerId = null,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        $response = $this->http->delete(
            '/seats',
            HttpClient::buildBody([
                'feature_code' => $featureCode,
                'count' => $count,
                'customer_id' => $customerId,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        return self::toTypedEvent($response);
    }

    /**
     * @return ApiResponse<SeatEvent>
     */
    public function set(
        string $featureCode,
        int $count = 0,
        ?string $customerId = null,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        $response = $this->http->put(
            '/seats',
            HttpClient::buildBody([
                'feature_code' => $featureCode,
                'count' => $count,
                'customer_id' => $customerId,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        return self::toTypedEvent($response);
    }

    /**
     * @param array<string, int> $seats
     * @return ApiResponse<SeatEvent[]>
     */
    public function setAll(
        array $seats,
        ?string $customerId = null,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        $response = $this->http->put(
            '/seats/bulk',
            HttpClient::buildBody([
                'seats' => $seats,
                'customer_id' => $customerId,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if ($response->success && is_array($response->data)) {
            $events = array_map(
                fn(array $item) => SeatEvent::fromArray($item),
                $response->data,
            );

            return new ApiResponse(
                success: true,
                data: $events,
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }

    /**
     * @return ApiResponse<SeatBalance>
     */
    public function getBalance(
        string $featureCode,
        ?string $customerId = null,
    ): ApiResponse {
        $response = $this->http->get(
            '/seats/balance',
            HttpClient::buildBody([
                'feature_code' => $featureCode,
                'customer_id' => $customerId,
            ]),
        );

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: SeatBalance::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }

    /**
     * @return ApiResponse<array<string, SeatBalance>>
     */
    public function getAllBalances(
        ?string $customerId = null,
    ): ApiResponse {
        $response = $this->http->get(
            '/seats/balances',
            HttpClient::buildBody([
                'customer_id' => $customerId,
            ]),
        );

        if ($response->success && is_array($response->data)) {
            $balances = [];
            foreach ($response->data as $featureCode => $balanceData) {
                if (is_array($balanceData)) {
                    $balances[$featureCode] = SeatBalance::fromArray($balanceData);
                }
            }

            return new ApiResponse(
                success: true,
                data: $balances,
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }

    /**
     * @return ApiResponse<SeatEvent>
     */
    private static function toTypedEvent(ApiResponse $response): ApiResponse
    {
        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: SeatEvent::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }
}
