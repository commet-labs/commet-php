<?php

declare(strict_types=1);

namespace Commet\Resources;

use Commet\ApiResponse;
use Commet\HttpClient;
use Commet\Models\WebhookEndpoint;

class WebhooksResource
{
    public function __construct(
        private readonly ?HttpClient $http = null,
    ) {}

    public function verify(string $payload, ?string $signature, string $secret): bool
    {
        if ($signature === null || $signature === '' || $secret === '' || $payload === '') {
            return false;
        }

        $expected = hash_hmac('sha256', $payload, $secret);

        return hash_equals($expected, $signature);
    }

    /**
     * @return array<string, mixed>|null
     */
    public function verifyAndParse(string $rawBody, ?string $signature, string $secret): ?array
    {
        if (!$this->verify($rawBody, $signature, $secret)) {
            return null;
        }

        try {
            $parsed = json_decode($rawBody, true, 512, JSON_THROW_ON_ERROR);
            return is_array($parsed) ? $parsed : null;
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
        $response = $this->http->get(
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
        ?string $idempotencyKey = null,
    ): ApiResponse {
        $response = $this->http->post(
            '/webhooks',
            HttpClient::buildBody([
                'url' => $url,
                'events' => $events,
                'description' => $description,
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
        return $this->http->delete("/webhooks/{$id}", idempotencyKey: $idempotencyKey);
    }

    /**
     * @return ApiResponse<array{success: bool, delivered_at: string}>
     */
    public function test(
        string $id,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        return $this->http->post("/webhooks/{$id}/test", idempotencyKey: $idempotencyKey);
    }
}
