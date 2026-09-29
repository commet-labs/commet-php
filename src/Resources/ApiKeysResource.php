<?php

declare(strict_types=1);

namespace Commet\Resources;

use Commet\HttpClient;
use Commet\Models\ApiKeysListResult;
use Commet\Models\CreateApiKeyParamsPermissions;
use Commet\Models\CreatedApiKey;
use Commet\Models\DeletedObject;

class ApiKeysResource
{
    public function __construct(
        private readonly HttpClient $http,
    ) {}

    /**
     * Permanently revoke and delete an API key.
     * @return DeletedObject
     */
    public function delete(
        string $id,
    ): DeletedObject {
        $response = $this->http->delete(
            "/api-keys/{$id}",
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid DeletedObject response payload");
        }

        return DeletedObject::fromArray($response->data);
    }

    /**
     * List API keys with cursor-based pagination. Keys are returned without the full secret.
     * @return ApiKeysListResult
     */
    public function list(
        ?string $cursor = null,
        ?int $limit = null,
    ): ApiKeysListResult {
        $response = $this->http->get(
            "/api-keys",
            HttpClient::buildBody([
                "cursor" => $cursor,
                "limit" => $limit,
            ]),
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid ApiKeysListResult response payload");
        }

        return ApiKeysListResult::fromArray($response->data);
    }

    /**
     * Create a full-access or restricted API key. Provide permissions to restrict access; the full key is returned only once. A restricted key with api_key: write may only create restricted keys with the same or fewer permissions, and they expire no later than the key that creates them.
     * @return CreatedApiKey
     */
    public function create(
        string $name,
        ?int $expiresInDays = null,
        ?CreateApiKeyParamsPermissions $permissions = null,
        ?string $idempotencyKey = null,
    ): CreatedApiKey {
        $response = $this->http->post(
            "/api-keys",
            HttpClient::buildBody([
                "name" => $name,
                "expires_in_days" => $expiresInDays,
                "permissions" => $permissions,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid CreatedApiKey response payload");
        }

        return CreatedApiKey::fromArray($response->data);
    }
}
