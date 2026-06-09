<?php

declare(strict_types=1);

namespace Commet\Resources;

use Commet\ApiResponse;
use Commet\HttpClient;
use Commet\Models\UsageQuota;
use Commet\Models\UsageQuotaEvent;

class QuotaResource
{
    public function __construct(
        private readonly HttpClient $http,
    ) {}

    /**
     * Add to a customer's quota allowance for a feature. Defaults to 1 if count is omitted.
     * @return ApiResponse<UsageQuotaEvent>
     */
    public function add(
        string $featureCode,
        ?string $customerId = null,
        ?string $externalId = null,
        ?int $count = null,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        $response = $this->http->post(
            "/usage/quota",
            HttpClient::buildBody([
                "customer_id" => $customerId,
                "external_id" => $externalId,
                "feature_code" => $featureCode,
                "count" => $count,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: UsageQuotaEvent::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }

    /**
     * Set a customer's quota allowance for a feature to an exact value.
     * @return ApiResponse<UsageQuotaEvent>
     */
    public function set(
        string $featureCode,
        int $count,
        ?string $customerId = null,
        ?string $externalId = null,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        $response = $this->http->put(
            "/usage/quota",
            HttpClient::buildBody([
                "customer_id" => $customerId,
                "external_id" => $externalId,
                "feature_code" => $featureCode,
                "count" => $count,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: UsageQuotaEvent::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }

    /**
     * Remove from a customer's quota allowance for a feature. Defaults to 1 if count is omitted. Returns 400 insufficient_balance if the balance would go negative.
     * @return ApiResponse<UsageQuotaEvent>
     */
    public function remove(
        string $featureCode,
        ?string $customerId = null,
        ?string $externalId = null,
        ?int $count = null,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        $response = $this->http->delete(
            "/usage/quota",
            HttpClient::buildBody([
                "customer_id" => $customerId,
                "external_id" => $externalId,
                "feature_code" => $featureCode,
                "count" => $count,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: UsageQuotaEvent::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }

    /**
     * Get the current quota allowance (used vs included) for a specific feature.
     * @return ApiResponse<UsageQuota>
     */
    public function get(
        string $customerId,
        string $featureCode,
    ): ApiResponse {
        $response = $this->http->get(
            "/usage/quota",
            HttpClient::buildBody([
                "customer_id" => $customerId,
                "feature_code" => $featureCode,
            ]),
        );

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: UsageQuota::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }

    /**
     * Get all quota allowances for a customer across every quota feature in their plan.
     * @return ApiResponse<UsageQuota[]>
     */
    public function getAll(
        string $customerId,
    ): ApiResponse {
        $response = $this->http->get(
            "/usage/quota/all",
            HttpClient::buildBody([
                "customer_id" => $customerId,
            ]),
        );

        if ($response->success && is_array($response->data)) {
            $items = array_map(
                fn(array $item) => UsageQuota::fromArray($item),
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
}
