<?php

declare(strict_types=1);

namespace Commet\Resources;

use Commet\HttpClient;
use Commet\Models\CreatedWebhook;
use Commet\Models\DeletedObject;
use Commet\Models\Webhook;
use Commet\Models\WebhookTest;
use Commet\Models\WebhooksListResult;

class GeneratedWebhooksResource
{
    public function __construct(
        private readonly HttpClient $http,
    ) {}

    /**
     * Retrieve a webhook endpoint by its public ID.
     * @return Webhook
     */
    public function get(
        string $id,
    ): Webhook {
        $response = $this->http->get(
            "/webhooks/{$id}",
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid Webhook response payload");
        }

        return Webhook::fromArray($response->data);
    }

    /**
     * Update a webhook endpoint. Only the provided fields change.
     * @param string[]|null $events
     * @return Webhook
     */
    public function update(
        string $id,
        ?string $url = null,
        ?array $events = null,
        ?string $description = null,
        ?bool $isActive = null,
        ?string $apiVersion = null,
        ?string $idempotencyKey = null,
    ): Webhook {
        $response = $this->http->patch(
            "/webhooks/{$id}",
            HttpClient::buildBody([
                "url" => $url,
                "events" => $events,
                "description" => $description,
                "is_active" => $isActive,
                "api_version" => $apiVersion,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid Webhook response payload");
        }

        return Webhook::fromArray($response->data);
    }

    /**
     * Permanently delete a webhook endpoint.
     * @return DeletedObject
     */
    public function delete(
        string $id,
    ): DeletedObject {
        $response = $this->http->delete(
            "/webhooks/{$id}",
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid DeletedObject response payload");
        }

        return DeletedObject::fromArray($response->data);
    }

    /**
     * Send a test event to a webhook endpoint to verify connectivity.
     * @return WebhookTest
     */
    public function test(
        string $id,
        ?string $idempotencyKey = null,
    ): WebhookTest {
        $response = $this->http->post(
            "/webhooks/{$id}/test",
            idempotencyKey: $idempotencyKey,
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid WebhookTest response payload");
        }

        return WebhookTest::fromArray($response->data);
    }

    /**
     * List webhook endpoints with cursor-based pagination.
     * @return WebhooksListResult
     */
    public function list(
        ?string $cursor = null,
        ?int $limit = null,
    ): WebhooksListResult {
        $response = $this->http->get(
            "/webhooks",
            HttpClient::buildBody([
                "cursor" => $cursor,
                "limit" => $limit,
            ]),
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid WebhooksListResult response payload");
        }

        return WebhooksListResult::fromArray($response->data);
    }

    /**
     * Create a new webhook endpoint. The response includes the signing secret which is only returned once.
     * @param string[] $events
     * @return CreatedWebhook
     */
    public function create(
        string $url,
        array $events,
        ?string $description = null,
        ?string $apiVersion = null,
        ?string $idempotencyKey = null,
    ): CreatedWebhook {
        $response = $this->http->post(
            "/webhooks",
            HttpClient::buildBody([
                "url" => $url,
                "events" => $events,
                "description" => $description,
                "api_version" => $apiVersion,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid CreatedWebhook response payload");
        }

        return CreatedWebhook::fromArray($response->data);
    }
}
