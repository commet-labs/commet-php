<?php

declare(strict_types=1);

namespace Commet\Resources;

use Commet\ApiResponse;
use Commet\HttpClient;
use Commet\Models\ApiKey;

class ApiKeysResource
{
    public function __construct(
        private readonly HttpClient $http,
    ) {}

    /**
     * @return ApiResponse<ApiKey[]>
     */
    public function list(
        ?int $limit = null,
        ?string $cursor = null,
    ): ApiResponse {
        $response = $this->http->get(
            '/api-keys',
            HttpClient::buildBody([
                'limit' => $limit,
                'cursor' => $cursor,
            ]),
        );

        if ($response->success && is_array($response->data)) {
            $keys = array_map(
                fn(array $item) => ApiKey::fromArray($item),
                $response->data,
            );

            return new ApiResponse(
                success: true,
                data: $keys,
                code: $response->code,
                message: $response->message,
                hasMore: $response->hasMore,
                nextCursor: $response->nextCursor,
            );
        }

        return $response;
    }

    /**
     * @return ApiResponse<ApiKey>
     */
    public function create(
        string $name,
        ?int $expiresInDays = null,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        $response = $this->http->post(
            '/api-keys',
            HttpClient::buildBody([
                'name' => $name,
                'expires_in_days' => $expiresInDays,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: ApiKey::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }

    /**
     * @return ApiResponse<void>
     */
    public function delete(
        string $id,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        return $this->http->delete("/api-keys/{$id}", idempotencyKey: $idempotencyKey);
    }
}
