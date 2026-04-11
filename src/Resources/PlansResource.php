<?php

declare(strict_types=1);

namespace Commet\Resources;

use Commet\ApiResponse;
use Commet\HttpClient;
use Commet\Models\Plan;

class PlansResource
{
    public function __construct(
        private readonly HttpClient $http,
    ) {}

    /**
     * @return ApiResponse<Plan[]>
     */
    public function list(
        ?bool $includePrivate = null,
        ?int $limit = null,
        ?string $cursor = null,
    ): ApiResponse {
        $response = $this->http->get(
            '/plans',
            HttpClient::buildBody([
                'include_private' => $includePrivate,
                'limit' => $limit,
                'cursor' => $cursor,
            ]),
        );

        if ($response->success && is_array($response->data)) {
            $plans = array_map(
                fn(array $item) => Plan::fromArray($item),
                $response->data,
            );

            return new ApiResponse(
                success: true,
                data: $plans,
                code: $response->code,
                message: $response->message,
                hasMore: $response->hasMore,
                nextCursor: $response->nextCursor,
            );
        }

        return $response;
    }

    /**
     * @return ApiResponse<Plan>
     */
    public function get(string $planCode): ApiResponse
    {
        $response = $this->http->get("/plans/{$planCode}");

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: Plan::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }
}
