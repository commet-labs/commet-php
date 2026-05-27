<?php

declare(strict_types=1);

namespace Commet\Resources;

use Commet\ApiResponse;
use Commet\HttpClient;
use Commet\Models\ActiveAddon;
use Commet\Models\Addon;

class AddonsResource
{
    public function __construct(
        private readonly HttpClient $http,
    ) {}

    /**
     * @return ApiResponse<ActiveAddon[]>
     */
    public function listActive(string $customerId): ApiResponse
    {
        $response = $this->http->get('/addons/active', ['customer_id' => $customerId]);

        if ($response->success && is_array($response->data)) {
            $addons = array_map(
                fn(array $item) => ActiveAddon::fromArray($item),
                $response->data,
            );

            return new ApiResponse(
                success: true,
                data: $addons,
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }

    /**
     * @deprecated Use listActive() instead
     * @return ApiResponse<ActiveAddon[]>
     */
    public function getActive(string $customerId): ApiResponse
    {
        return $this->listActive($customerId);
    }

    /**
     * @return ApiResponse<Addon[]>
     */
    public function list(
        ?int $limit = null,
        ?string $cursor = null,
    ): ApiResponse {
        $response = $this->http->get(
            '/addons',
            HttpClient::buildBody([
                'limit' => $limit,
                'cursor' => $cursor,
            ]),
        );

        if ($response->success && is_array($response->data)) {
            $addons = array_map(
                fn(array $item) => Addon::fromArray($item),
                $response->data,
            );

            return new ApiResponse(
                success: true,
                data: $addons,
                code: $response->code,
                message: $response->message,
                hasMore: $response->hasMore,
                nextCursor: $response->nextCursor,
            );
        }

        return $response;
    }

    /**
     * @return ApiResponse<Addon>
     */
    public function get(string $id): ApiResponse
    {
        $response = $this->http->get("/addons/{$id}");

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: Addon::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }

    /**
     * @return ApiResponse<Addon>
     */
    public function create(
        string $name,
        int $basePrice,
        string $featureId,
        string $consumptionModel,
        ?string $description = null,
        ?int $includedUnits = null,
        ?int $overageRate = null,
        ?int $creditCost = null,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        $response = $this->http->post(
            '/addons',
            HttpClient::buildBody([
                'name' => $name,
                'base_price' => $basePrice,
                'feature_id' => $featureId,
                'consumption_model' => $consumptionModel,
                'description' => $description,
                'included_units' => $includedUnits,
                'overage_rate' => $overageRate,
                'credit_cost' => $creditCost,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: Addon::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }

    /**
     * @return ApiResponse<Addon>
     */
    public function update(
        string $id,
        ?string $name = null,
        ?string $description = null,
        ?int $basePrice = null,
        ?int $includedUnits = null,
        ?int $overageRate = null,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        $response = $this->http->put(
            "/addons/{$id}",
            HttpClient::buildBody([
                'name' => $name,
                'description' => $description,
                'base_price' => $basePrice,
                'included_units' => $includedUnits,
                'overage_rate' => $overageRate,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: Addon::fromArray($response->data),
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
        string $id,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        return $this->http->delete("/addons/{$id}", idempotencyKey: $idempotencyKey);
    }
}
