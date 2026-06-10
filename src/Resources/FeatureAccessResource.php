<?php

declare(strict_types=1);

namespace Commet\Resources;

use Commet\ApiResponse;
use Commet\HttpClient;
use Commet\Models\FeatureAccess;
use Commet\Models\FeatureLookup;

class FeatureAccessResource
{
    public function __construct(
        private readonly HttpClient $http,
    ) {}

    /**
     * List all features for a customer's active subscription, scoped by the customerId query parameter.
     * @return ApiResponse<FeatureAccess[]>
     */
    public function list(
        string $customerId,
    ): ApiResponse {
        $response = $this->http->get(
            "/feature-access",
            HttpClient::buildBody([
                "customer_id" => $customerId,
            ]),
        );

        if ($response->success && is_array($response->data)) {
            $items = array_map(
                fn(array $item) => FeatureAccess::fromArray($item),
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
     * Get feature access details for a customer. Use action=canUse to check if the customer can consume one more unit.
     * @return ApiResponse<FeatureLookup>
     */
    public function get(
        string $code,
        string $customerId,
        ?string $action = null,
    ): ApiResponse {
        $response = $this->http->get(
            "/feature-access/{$code}",
            HttpClient::buildBody([
                "customer_id" => $customerId,
                "action" => $action,
            ]),
        );

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: FeatureLookup::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }

    /**
     * Get feature access details for a customer. Use action=canUse to check if the customer can consume one more unit.
     * @return ApiResponse<FeatureLookup>
     */
    public function canUse(
        string $code,
        string $customerId,
    ): ApiResponse {
        $response = $this->http->get(
            "/feature-access/{$code}",
            HttpClient::buildBody([
                "action" => "canUse",
                "customer_id" => $customerId,
            ]),
        );

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: FeatureLookup::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }
}
