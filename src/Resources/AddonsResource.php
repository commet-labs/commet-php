<?php

declare(strict_types=1);

namespace Commet\Resources;

use Commet\ApiResponse;
use Commet\HttpClient;
use Commet\Models\ActiveAddon;
use Commet\Models\Addon;
use Commet\Models\DeletedObject;

class AddonsResource
{
    public function __construct(
        private readonly HttpClient $http,
    ) {}

    /**
     * List all active add-ons for a customer's subscription.
     * @return ApiResponse<ActiveAddon[]>
     */
    public function listActive(
        string $customerId,
    ): ApiResponse {
        $response = $this->http->get(
            "/active-addons",
            HttpClient::buildBody([
                "customer_id" => $customerId,
            ]),
        );

        if ($response->success && is_array($response->data)) {
            $items = array_map(
                fn(array $item) => ActiveAddon::fromArray($item),
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
     * List all add-ons with cursor-based pagination.
     * @return ApiResponse<Addon[]>
     */
    public function list(
        ?int $limit = null,
        ?string $cursor = null,
    ): ApiResponse {
        $response = $this->http->get(
            "/addons",
            HttpClient::buildBody([
                "limit" => $limit,
                "cursor" => $cursor,
            ]),
        );

        if ($response->success && is_array($response->data)) {
            $items = array_map(
                fn(array $item) => Addon::fromArray($item),
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
     * Retrieve an add-on by its public ID or slug.
     * @return ApiResponse<Addon>
     */
    public function get(
        string $id,
    ): ApiResponse {
        $response = $this->http->get(
            "/addons/{$id}",
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
     * Create a new add-on linked to a feature. Each feature can only be assigned to one add-on.
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
            "/addons",
            HttpClient::buildBody([
                "name" => $name,
                "description" => $description,
                "base_price" => $basePrice,
                "feature_id" => $featureId,
                "consumption_model" => $consumptionModel,
                "included_units" => $includedUnits,
                "overage_rate" => $overageRate,
                "credit_cost" => $creditCost,
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
     * Update an add-on's name, description, or pricing.
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
                "name" => $name,
                "description" => $description,
                "base_price" => $basePrice,
                "included_units" => $includedUnits,
                "overage_rate" => $overageRate,
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
     * Soft-delete an add-on. Fails if the add-on has active subscriptions.
     * @return ApiResponse<DeletedObject>
     */
    public function delete(
        string $id,
    ): ApiResponse {
        $response = $this->http->delete(
            "/addons/{$id}",
        );

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: DeletedObject::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }
}
