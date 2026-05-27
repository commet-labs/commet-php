<?php

declare(strict_types=1);

namespace Commet\Resources;

use Commet\ApiResponse;
use Commet\HttpClient;
use Commet\Models\CanUseResult;
use Commet\Models\Feature;
use Commet\Models\FeatureManage;

class FeaturesResource
{
    public function __construct(
        private readonly HttpClient $http,
    ) {}

    /**
     * @return ApiResponse<Feature>
     */
    public function get(string $code, string $customerId): ApiResponse
    {
        $response = $this->http->get("/features/{$code}", ['customer_id' => $customerId]);

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: Feature::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }

    /**
     * @return ApiResponse<CanUseResult>
     */
    public function canUse(string $code, string $customerId): ApiResponse
    {
        $response = $this->http->get(
            "/features/{$code}",
            ['customer_id' => $customerId, 'action' => 'canUse'],
        );

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: CanUseResult::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }

    /**
     * @return ApiResponse<Feature[]>
     */
    public function list(string $customerId): ApiResponse
    {
        $response = $this->http->get('/features', ['customer_id' => $customerId]);

        if ($response->success && is_array($response->data)) {
            $features = array_map(
                fn(array $item) => Feature::fromArray($item),
                $response->data,
            );

            return new ApiResponse(
                success: true,
                data: $features,
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }

    /**
     * @return ApiResponse<FeatureManage>
     */
    public function create(
        string $code,
        string $name,
        string $type,
        ?string $description = null,
        ?string $unitName = null,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        $response = $this->http->post(
            '/features/manage',
            HttpClient::buildBody([
                'code' => $code,
                'name' => $name,
                'type' => $type,
                'description' => $description,
                'unit_name' => $unitName,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: FeatureManage::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }

    /**
     * @return ApiResponse<FeatureManage>
     */
    public function update(
        string $code,
        ?string $name = null,
        ?string $description = null,
        ?string $unitName = null,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        $response = $this->http->put(
            "/features/{$code}/manage",
            HttpClient::buildBody([
                'name' => $name,
                'description' => $description,
                'unit_name' => $unitName,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: FeatureManage::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }

    /**
     * @return ApiResponse<array{id: string, deleted: true}>
     */
    public function delete(
        string $code,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        return $this->http->delete("/features/{$code}/manage", idempotencyKey: $idempotencyKey);
    }
}
