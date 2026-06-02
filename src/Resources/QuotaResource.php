<?php

declare(strict_types=1);

namespace Commet\Resources;

use Commet\ApiResponse;
use Commet\HttpClient;
use Commet\Models\QuotaAllowance;
use Commet\Models\QuotaEvent;

class QuotaResource
{
    public function __construct(
        private readonly HttpClient $http,
    ) {}

    /**
     * @return ApiResponse<QuotaEvent>
     */
    public function add(
        string $featureCode,
        int $count = 1,
        ?string $customerId = null,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        $response = $this->http->post(
            '/usage/quota',
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
     * @return ApiResponse<QuotaEvent>
     */
    public function set(
        string $featureCode,
        int $count,
        ?string $customerId = null,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        $response = $this->http->put(
            '/usage/quota',
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
     * @return ApiResponse<QuotaEvent>
     */
    public function remove(
        string $featureCode,
        int $count = 1,
        ?string $customerId = null,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        $response = $this->http->delete(
            '/usage/quota',
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
     * @return ApiResponse<QuotaAllowance>
     */
    public function get(
        string $featureCode,
        ?string $customerId = null,
    ): ApiResponse {
        $response = $this->http->get(
            '/usage/quota',
            HttpClient::buildBody([
                'feature_code' => $featureCode,
                'customer_id' => $customerId,
            ]),
        );

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: QuotaAllowance::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }

    /**
     * @return ApiResponse<QuotaAllowance[]>
     */
    public function getAll(
        ?string $customerId = null,
    ): ApiResponse {
        $response = $this->http->get(
            '/usage/quota/all',
            HttpClient::buildBody([
                'customer_id' => $customerId,
            ]),
        );

        if ($response->success && is_array($response->data)) {
            $allowances = array_map(
                fn(array $item) => QuotaAllowance::fromArray($item),
                $response->data,
            );

            return new ApiResponse(
                success: true,
                data: $allowances,
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }

    /**
     * @return ApiResponse<QuotaEvent>
     */
    private static function toTypedEvent(ApiResponse $response): ApiResponse
    {
        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: QuotaEvent::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }
}
