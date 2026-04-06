<?php

declare(strict_types=1);

namespace Commet\Resources;

use Commet\ApiResponse;
use Commet\HttpClient;

class UsageResource
{
    public function __construct(
        private readonly HttpClient $http,
    ) {}

    /**
     * @param array<string, string>|null $properties
     */
    public function track(
        string $feature,
        ?string $customerId = null,
        ?string $externalId = null,
        ?int $value = null,
        ?string $model = null,
        ?int $inputTokens = null,
        ?int $outputTokens = null,
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
            'external_id' => $externalId,
            'idempotency_key' => $idempotencyKey,
            'timestamp' => $timestamp ?? gmdate('c'),
            'properties' => $formattedProperties,
        ]);

        if ($model !== null) {
            $body = array_merge($body, HttpClient::buildBody([
                'model' => $model,
                'input_tokens' => $inputTokens,
                'output_tokens' => $outputTokens,
                'cache_read_tokens' => $cacheReadTokens,
                'cache_write_tokens' => $cacheWriteTokens,
            ]));
        } elseif ($value !== null) {
            $body['value'] = $value;
        }

        return $this->http->post('/usage/events', $body, idempotencyKey: $idempotencyKey);
    }

    /**
     * @param list<array<string, mixed>> $events
     */
    public function trackBatch(
        array $events,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        $mapped = [];

        foreach ($events as $event) {
            $properties = $event['properties'] ?? null;
            $formattedProperties = null;
            if (is_array($properties)) {
                $formattedProperties = [];
                foreach ($properties as $key => $propertyValue) {
                    $formattedProperties[] = ['property' => $key, 'value' => $propertyValue];
                }
            }

            $entry = HttpClient::buildBody([
                'feature' => $event['feature'] ?? null,
                'customer_id' => $event['customer_id'] ?? null,
                'external_id' => $event['external_id'] ?? null,
                'idempotency_key' => $event['idempotency_key'] ?? null,
                'timestamp' => $event['timestamp'] ?? gmdate('c'),
                'properties' => $formattedProperties,
            ]);

            if (isset($event['model'])) {
                $entry = array_merge($entry, HttpClient::buildBody([
                    'model' => $event['model'],
                    'input_tokens' => $event['input_tokens'] ?? null,
                    'output_tokens' => $event['output_tokens'] ?? null,
                    'cache_read_tokens' => $event['cache_read_tokens'] ?? null,
                    'cache_write_tokens' => $event['cache_write_tokens'] ?? null,
                ]));
            } elseif (isset($event['value'])) {
                $entry['value'] = $event['value'];
            }

            $mapped[] = $entry;
        }

        return $this->http->post(
            '/usage/events/batch',
            ['events' => $mapped],
            idempotencyKey: $idempotencyKey,
        );
    }
}
