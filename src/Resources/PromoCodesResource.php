<?php

declare(strict_types=1);

namespace Commet\Resources;

use Commet\ApiResponse;
use Commet\HttpClient;
use Commet\Models\PromoCode;

class PromoCodesResource
{
    public function __construct(
        private readonly HttpClient $http,
    ) {}

    /**
     * @return ApiResponse<PromoCode[]>
     */
    public function list(
        ?int $limit = null,
        ?string $cursor = null,
    ): ApiResponse {
        $response = $this->http->get(
            '/promo-codes',
            HttpClient::buildBody([
                'limit' => $limit,
                'cursor' => $cursor,
            ]),
        );

        if ($response->success && is_array($response->data)) {
            $codes = array_map(
                fn(array $item) => PromoCode::fromArray($item),
                $response->data,
            );

            return new ApiResponse(
                success: true,
                data: $codes,
                code: $response->code,
                message: $response->message,
                hasMore: $response->hasMore,
                nextCursor: $response->nextCursor,
            );
        }

        return $response;
    }

    /**
     * @return ApiResponse<PromoCode>
     */
    public function get(string $id): ApiResponse
    {
        $response = $this->http->get("/promo-codes/{$id}");

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: PromoCode::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }

    /**
     * @param string[] $planIds
     * @return ApiResponse<PromoCode>
     */
    public function create(
        string $code,
        string $discountType,
        int $discountValue,
        ?int $durationCycles = null,
        ?int $maxRedemptions = null,
        ?string $expiresAt = null,
        ?array $planIds = null,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        $response = $this->http->post(
            '/promo-codes',
            HttpClient::buildBody([
                'code' => $code,
                'discount_type' => $discountType,
                'discount_value' => $discountValue,
                'duration_cycles' => $durationCycles,
                'max_redemptions' => $maxRedemptions,
                'expires_at' => $expiresAt,
                'plan_ids' => $planIds,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: PromoCode::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }

    /**
     * @param string[] $planIds
     * @return ApiResponse<PromoCode>
     */
    public function update(
        string $id,
        ?int $maxRedemptions = null,
        ?string $expiresAt = null,
        ?bool $active = null,
        ?array $planIds = null,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        $response = $this->http->put(
            "/promo-codes/{$id}",
            HttpClient::buildBody([
                'max_redemptions' => $maxRedemptions,
                'expires_at' => $expiresAt,
                'active' => $active,
                'plan_ids' => $planIds,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: PromoCode::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }
}
