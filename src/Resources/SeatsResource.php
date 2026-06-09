<?php

declare(strict_types=1);

namespace Commet\Resources;

use Commet\ApiResponse;
use Commet\HttpClient;
use Commet\Models\BulkSeatUpdate;
use Commet\Models\SeatBalance;
use Commet\Models\SeatBalanceListItem;
use Commet\Models\SeatEvent;

class SeatsResource
{
    public function __construct(
        private readonly HttpClient $http,
    ) {}

    /**
     * Add seats to a customer's subscription. Prorates charges for the current billing period.
     * @return ApiResponse<SeatEvent>
     */
    public function add(
        string $customerId,
        string $featureCode,
        int $count,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        $response = $this->http->post(
            "/seats",
            HttpClient::buildBody([
                "customer_id" => $customerId,
                "feature_code" => $featureCode,
                "count" => $count,
            ]),
            idempotencyKey: $idempotencyKey,
        );

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

    /**
     * Set seats to an exact count.
     * @return ApiResponse<SeatEvent>
     */
    public function set(
        string $customerId,
        string $featureCode,
        int $count,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        $response = $this->http->put(
            "/seats",
            HttpClient::buildBody([
                "customer_id" => $customerId,
                "feature_code" => $featureCode,
                "count" => $count,
            ]),
            idempotencyKey: $idempotencyKey,
        );

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

    /**
     * Remove seats from a customer's subscription. Takes effect at the end of the billing period.
     * @return ApiResponse<SeatEvent>
     */
    public function remove(
        string $customerId,
        string $featureCode,
        int $count,
    ): ApiResponse {
        $response = $this->http->delete(
            "/seats",
            HttpClient::buildBody([
                "customer_id" => $customerId,
                "feature_code" => $featureCode,
                "count" => $count,
            ]),
        );

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

    /**
     * Set all seat types at once.
     * @param array<string, int> $seats
     * @return ApiResponse<BulkSeatUpdate[]>
     */
    public function setAll(
        string $customerId,
        array $seats,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        $response = $this->http->put(
            "/seats/bulk",
            HttpClient::buildBody([
                "customer_id" => $customerId,
                "seats" => $seats,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if ($response->success && is_array($response->data)) {
            $items = array_map(
                fn(array $item) => BulkSeatUpdate::fromArray($item),
                $response->data,
            );

            return new ApiResponse(
                success: true,
                data: $items,
                code: $response->code,
                message: $response->message,
                hasMore: $response->hasMore,
                nextCursor: $response->nextCursor,
            );
        }

        return $response;
    }

    /**
     * Get current balance for a specific seat type.
     * @return ApiResponse<SeatBalance>
     */
    public function getBalance(
        string $customerId,
        string $featureCode,
    ): ApiResponse {
        $response = $this->http->get(
            "/seats/balance",
            HttpClient::buildBody([
                "customer_id" => $customerId,
                "feature_code" => $featureCode,
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
     * Get the current balance for all seat types in a customer's subscription.
     * @return ApiResponse<SeatBalanceListItem>
     */
    public function getAllBalances(
        string $customerId,
    ): ApiResponse {
        $response = $this->http->get(
            "/seats/balances",
            HttpClient::buildBody([
                "customer_id" => $customerId,
            ]),
        );

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: SeatBalanceListItem::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }
}
