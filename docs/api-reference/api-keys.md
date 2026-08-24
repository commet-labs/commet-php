# Api Keys

API version: `2026-07-31`

## delete

`$commet->apiKeys->delete(...)`

`DELETE /api-keys/{id}` · operation `delete-api-key`

Permanently revoke and delete an API key.

### Parameters

- `id` (`string`, required)

### Returns

`DeletedObject`

## list

`$commet->apiKeys->list(...)`

`GET /api-keys` · operation `list-api-keys`

List API keys with cursor-based pagination. Keys are returned without the full secret.

### Parameters

- `cursor` (`string`, optional)
- `limit` (`int`, optional)

### Returns

`ApiKeysListResult`

## create

`$commet->apiKeys->create(...)`

`POST /api-keys` · operation `create-api-key`

Create a new API key. The full key is only returned once in the response.

### Parameters

- `name` (`string`, required)
- `expiresInDays` (`int`, optional)

### Request options

- `idempotencyKey` (`string`, optional) — Unique key used to safely retry this write for 24 hours without applying it twice.

### Returns

`CreatedApiKey`
