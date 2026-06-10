<?php

declare(strict_types=1);

namespace Commet\Resources;

use Commet\ApiResponse;
use Commet\Enums\FeatureType;
use Commet\HttpClient;
use Commet\Models\DeletedObject;
use Commet\Models\Feature;

class FeaturesResource
{
    public function __construct(
        private readonly HttpClient $http,
    ) {}

    /**
     * List every feature defined in the organization. This is the organization's feature catalog (definitions), not a customer's feature access.
     * @return ApiResponse<Feature[]>
     */
    public function list(

    ): ApiResponse {
        $response = $this->http->get(
            "/features",
        );

        if ($response->success && is_array($response->data)) {
            $items = array_map(
                fn(array $item) => Feature::fromArray($item),
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
     * Get a single feature definition by code from the organization's feature catalog.
     * @return ApiResponse<Feature>
     */
    public function get(
        string $code,
    ): ApiResponse {
        $response = $this->http->get(
            "/features/{$code}",
        );

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
     * Create a new feature. Code must be lowercase alphanumeric with underscores.
     * @return ApiResponse<Feature>
     */
    public function create(
        string $name,
        string $code,
        FeatureType $type,
        ?string $description = null,
        ?string $unitName = null,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        $response = $this->http->post(
            "/features/manage",
            HttpClient::buildBody([
                "name" => $name,
                "code" => $code,
                "type" => $type->value,
                "description" => $description,
                "unit_name" => $unitName,
            ]),
            idempotencyKey: $idempotencyKey,
        );

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
     * Update a feature's name, description, or unit name. At least one field must be provided.
     * @return ApiResponse<Feature>
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
                "name" => $name,
                "description" => $description,
                "unit_name" => $unitName,
            ]),
            idempotencyKey: $idempotencyKey,
        );

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
     * Delete a feature. Fails if the feature is attached to active plans or has an active add-on.
     * @return ApiResponse<DeletedObject>
     */
    public function delete(
        string $code,
    ): ApiResponse {
        $response = $this->http->delete(
            "/features/{$code}/manage",
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
