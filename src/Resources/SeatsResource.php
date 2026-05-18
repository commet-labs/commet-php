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

    private static function resolveCode(?string $featureCode, ?string $seatType): string
    {
        $code = $featureCode ?? $seatType;
        if ($code === null) {
            throw new \InvalidArgumentException('Either $featureCode or $seatType must be provided');
        }
        return $code;
    }

    /**
     * @param string|null $featureCode The feature code identifying the seat type.
     * @param string|null $seatType Deprecated. Use $featureCode instead.
     * @return ApiResponse<SeatEvent>
     */
    public function add(
        ?string $featureCode = null,
        int $count = 0,
        ?string $customerId = null,
        ?string $idempotencyKey = null,
        ?string $seatType = null,
    ): ApiResponse {
        $code = self::resolveCode($featureCode, $seatType);
        $response = $this->http->post(
            '/seats',
            HttpClient::buildBody([
                'seat_type' => $code,
                'count' => $count,
                'customer_id' => $customerId,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        return self::toTypedEvent($response);
    }

    /**
     * @param string|null $featureCode The feature code identifying the seat type.
     * @param string|null $seatType Deprecated. Use $featureCode instead.
     * @return ApiResponse<SeatEvent>
     */
    public function remove(
        ?string $featureCode = null,
        int $count = 0,
        ?string $customerId = null,
        ?string $idempotencyKey = null,
        ?string $seatType = null,
    ): ApiResponse {
        $code = self::resolveCode($featureCode, $seatType);
        $response = $this->http->delete(
            '/seats',
            HttpClient::buildBody([
                'seat_type' => $code,
                'count' => $count,
                'customer_id' => $customerId,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        return self::toTypedEvent($response);
    }

    /**
     * @param string|null $featureCode The feature code identifying the seat type.
     * @param string|null $seatType Deprecated. Use $featureCode instead.
     * @return ApiResponse<SeatEvent>
     */
    public function set(
        ?string $featureCode = null,
        int $count = 0,
        ?string $customerId = null,
        ?string $idempotencyKey = null,
        ?string $seatType = null,
    ): ApiResponse {
        $code = self::resolveCode($featureCode, $seatType);
        $response = $this->http->put(
            '/seats',
            HttpClient::buildBody([
                'seat_type' => $code,
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
     * @param string|null $featureCode The feature code identifying the seat type.
     * @param string|null $seatType Deprecated. Use $featureCode instead.
     * @return ApiResponse<SeatBalance>
     */
    public function getBalance(
        ?string $featureCode = null,
        ?string $customerId = null,
        ?string $seatType = null,
    ): ApiResponse {
        $code = self::resolveCode($featureCode, $seatType);
        $response = $this->http->get(
            '/seats/balance',
            HttpClient::buildBody([
                'seat_type' => $code,
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
            foreach ($response->data as $seatType => $balanceData) {
                if (is_array($balanceData)) {
                    $balances[$seatType] = SeatBalance::fromArray($balanceData);
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
