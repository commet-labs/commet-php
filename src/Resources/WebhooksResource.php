<?php

declare(strict_types=1);

namespace Commet\Resources;

use Commet\ApiResponse;
use Commet\HttpClient;
use Commet\Models\WebhookEndpoint;
use Commet\Webhooks\WebhookEvent;

class WebhooksResource
{
    public function __construct(
        private readonly ?HttpClient $http = null,
    ) {}

    private function http(): HttpClient
    {
        if ($this->http === null) {
            throw new \LogicException(
                'WebhooksResource was constructed without an HttpClient. '
                . 'Signature helpers (verify, verifyAndParse) work standalone, '
                . 'but API methods require the Commet client.',
            );
        }

        return $this->http;
    }

    public function verify(string $payload, ?string $signature, string $secret): bool
    {
        if ($signature === null || $signature === '' || $secret === '' || $payload === '') {
            return false;
        }

        $expected = hash_hmac('sha256', $payload, $secret);

        return hash_equals($expected, $signature);
    }

    public function verifyAndParse(string $rawBody, ?string $signature, string $secret): ?WebhookEvent
    {
        if (!$this->verify($rawBody, $signature, $secret)) {
            return null;
        }

        try {
            $parsed = json_decode($rawBody, true, 512, JSON_THROW_ON_ERROR);
            return is_array($parsed) ? WebhookEvent::fromArray($parsed) : null;
        } catch (\JsonException) {
            return null;
        }
    }

    /**
     * @return ApiResponse<WebhookEndpoint[]>
     */
    public function list(
        ?int $limit = null,
        ?string $cursor = null,
    ): ApiResponse {
        $response = $this->http()->get(
            '/webhooks',
            HttpClient::buildBody([
                'limit' => $limit,
                'cursor' => $cursor,
            ]),
        );

        if ($response->success && is_array($response->data)) {
            $endpoints = array_map(
                fn(array $item) => WebhookEndpoint::fromArray($item),
                $response->data,
            );

            return new ApiResponse(
                success: true,
                data: $endpoints,
                code: $response->code,
                message: $response->message,
                hasMore: $response->hasMore,
                nextCursor: $response->nextCursor,
            );
        }

        return $response;
    }

    /**
     * @param string[] $events
     * @return ApiResponse<WebhookEndpoint>
     */
    public function create(
        string $url,
        array $events,
        ?string $description = null,
        ?string $apiVersion = null,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        $response = $this->http()->post(
            '/webhooks',
            HttpClient::buildBody([
                'url' => $url,
                'events' => $events,
                'description' => $description,
                'api_version' => $apiVersion,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: WebhookEndpoint::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }

    /**
     * @return ApiResponse<WebhookEndpoint>
     */
    public function get(string $id): ApiResponse
    {
        $response = $this->http()->get("/webhooks/{$id}");

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: WebhookEndpoint::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }

    /**
     * @param string[]|null $events
     * @return ApiResponse<WebhookEndpoint>
     */
    public function update(
        string $id,
        ?string $url = null,
        ?array $events = null,
        ?string $description = null,
        ?bool $isActive = null,
        ?string $apiVersion = null,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        $response = $this->http()->put(
            "/webhooks/{$id}",
            HttpClient::buildBody([
                'url' => $url,
                'events' => $events,
                'description' => $description,
                'is_active' => $isActive,
                'api_version' => $apiVersion,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: WebhookEndpoint::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }

    /**
     * @return ApiResponse<array{id: string, deleted: true}>
     */
    public function delete(
        string $id,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        return $this->http()->delete("/webhooks/{$id}", idempotencyKey: $idempotencyKey);
    }

    /**
     * @return ApiResponse<array{success: bool, delivered_at: string}>
     */
    public function test(
        string $id,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        return $this->http()->post("/webhooks/{$id}/test", idempotencyKey: $idempotencyKey);
    }
}
