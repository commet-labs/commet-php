# Webhooks

API version: `2026-07-31`

## get

`$commet->webhooks->get(...)`

`GET /webhooks/{id}` · operation `get-webhook-endpoint`

Retrieve a webhook endpoint by its public ID.

### Parameters

- `id` (`string`, required)

### Returns

`Webhook`

## update

`$commet->webhooks->update(...)`

`PATCH /webhooks/{id}` · operation `update-webhook-endpoint`

Update a webhook endpoint. Only the provided fields change.

### Parameters

- `id` (`string`, required)
- `url` (`string`, optional)
- `events` (`array`, optional)
- `description` (`string | null`, optional)
- `isActive` (`bool`, optional)
- `apiVersion` (`string`, optional)

### Request options

- `idempotencyKey` (`string`, optional) — Unique key used to safely retry this write for 24 hours without applying it twice.

### Returns

`Webhook`

## delete

`$commet->webhooks->delete(...)`

`DELETE /webhooks/{id}` · operation `delete-webhook-endpoint`

Permanently delete a webhook endpoint.

### Parameters

- `id` (`string`, required)

### Returns

`DeletedObject`

## test

`$commet->webhooks->test(...)`

`POST /webhooks/{id}/test` · operation `test-webhook-endpoint`

Send a test event to a webhook endpoint to verify connectivity.

### Parameters

- `id` (`string`, required)

### Request options

- `idempotencyKey` (`string`, optional) — Unique key used to safely retry this write for 24 hours without applying it twice.

### Returns

`WebhookTest`

## list

`$commet->webhooks->list(...)`

`GET /webhooks` · operation `list-webhook-endpoints`

List webhook endpoints with cursor-based pagination.

### Parameters

- `cursor` (`string`, optional)
- `limit` (`int`, optional)

### Returns

`WebhooksListResult`

## create

`$commet->webhooks->create(...)`

`POST /webhooks` · operation `create-webhook-endpoint`

Create a new webhook endpoint. The response includes the signing secret which is only returned once.

### Parameters

- `url` (`string`, required)
- `events` (`array`, required)
- `description` (`string`, optional)
- `apiVersion` (`string`, optional)

### Request options

- `idempotencyKey` (`string`, optional) — Unique key used to safely retry this write for 24 hours without applying it twice.

### Returns

`CreatedWebhook`
