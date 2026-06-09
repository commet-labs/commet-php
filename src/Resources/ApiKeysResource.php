<?php

declare(strict_types=1);

namespace Commet\Resources;

use Commet\ApiResponse;
use Commet\HttpClient;
use Commet\Models\ApiKey;
use Commet\Models\CreatedApiKey;
use Commet\Models\DeletedObject;

class ApiKeysResource
{
    public function __construct(
        private readonly HttpClient $http,
    ) {}

    /**
     * List API keys with cursor-based pagination. Keys are returned without the full secret.
     * @return ApiResponse<ApiKey[]>
     */
    public function list(
        ?string $cursor = null,
        ?int $limit = null,
    ): ApiResponse {
        $response = $this->http->get(
            "/api-keys",
            HttpClient::buildBody([
                "cursor" => $cursor,
                "limit" => $limit,
            ]),
        );

        if ($response->success && is_array($response->data)) {
            $items = array_map(
                fn(array $item) => ApiKey::fromArray($item),
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
     * Create a new API key. The full key is only returned once in the response.
     * @return ApiResponse<CreatedApiKey>
     */
    public function create(
        string $name,
        ?int $expiresInDays = null,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        $response = $this->http->post(
            "/api-keys",
            HttpClient::buildBody([
                "name" => $name,
                "expires_in_days" => $expiresInDays,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: CreatedApiKey::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }

    /**
     * Permanently revoke and delete an API key.
     * @return ApiResponse<DeletedObject>
     */
    public function delete(
        string $id,
    ): ApiResponse {
        $response = $this->http->delete(
            "/api-keys/{$id}",
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
