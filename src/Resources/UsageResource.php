<?php

declare(strict_types=1);

namespace Commet\Resources;

use Commet\ApiResponse;
use Commet\HttpClient;
use Commet\Models\UsageEvent;

class UsageResource
{
    public function __construct(
        private readonly HttpClient $http,
    ) {}

    /**
     * @param array<string, string>|null $properties
     * @return ApiResponse<UsageEvent>
     */
    public function track(
        string $feature,
        ?string $customerId = null,
        ?int $value = null,
        ?string $idempotencyKey = null,
        ?string $timestamp = null,
        ?array $properties = null,
    ): ApiResponse {
        $formattedProperties = null;
        if ($properties !== null) {
            $formattedProperties = [];
            foreach ($properties as $key => $propertyValue) {
                $formattedProperties[] = ['property' => $key, 'value' => $propertyValue];
            }
        }

        $body = HttpClient::buildBody([
            'feature' => $feature,
            'customer_id' => $customerId,
            'idempotency_key' => $idempotencyKey,
            'timestamp' => $timestamp ?? gmdate('c'),
            'properties' => $formattedProperties,
            'value' => $value,
        ]);

        $response = $this->http->post('/usage/events', $body, idempotencyKey: $idempotencyKey);

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: UsageEvent::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }

    /**
     * @param array<string, string>|null $properties
     * @return ApiResponse<UsageEvent>
     */
    public function trackModelTokens(
        string $feature,
        string $model,
        int $inputTokens,
        int $outputTokens,
        ?string $customerId = null,
        ?int $cacheReadTokens = null,
        ?int $cacheWriteTokens = null,
        ?string $idempotencyKey = null,
        ?string $timestamp = null,
        ?array $properties = null,
    ): ApiResponse {
        $formattedProperties = null;
        if ($properties !== null) {
            $formattedProperties = [];
            foreach ($properties as $key => $propertyValue) {
                $formattedProperties[] = ['property' => $key, 'value' => $propertyValue];
            }
        }

        $body = HttpClient::buildBody([
            'feature' => $feature,
            'customer_id' => $customerId,
            'idempotency_key' => $idempotencyKey,
            'timestamp' => $timestamp ?? gmdate('c'),
            'properties' => $formattedProperties,
            'model' => $model,
            'input_tokens' => $inputTokens,
            'output_tokens' => $outputTokens,
            'cache_read_tokens' => $cacheReadTokens,
            'cache_write_tokens' => $cacheWriteTokens,
        ]);

        $response = $this->http->post('/usage/events', $body, idempotencyKey: $idempotencyKey);

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: UsageEvent::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }

    /**
     * @return ApiResponse<array<string, mixed>>
     */
    public function check(
        string $customerId,
        string $featureCode,
        int $quantity,
    ): ApiResponse {
        return $this->http->post('/usage/check', [
            'customer_id' => $customerId,
            'feature_code' => $featureCode,
            'quantity' => $quantity,
        ]);
    }
}
