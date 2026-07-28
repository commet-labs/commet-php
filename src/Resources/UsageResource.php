<?php

declare(strict_types=1);

namespace Commet\Resources;

use Commet\HttpClient;
use Commet\Models\TrackUsageParamsPropertiesItem;
use Commet\Models\UsageAdjustment;
use Commet\Models\UsageCheck;
use Commet\Models\UsageEvent;

class UsageResource
{
    public function __construct(
        private readonly HttpClient $http,
    ) {}

    /**
     * Check if a customer can consume a feature before actual consumption. Returns availability and cost estimates based on the plan's consumption model.
     * @return UsageCheck
     */
    public function check(
        string $customerId,
        string $featureCode,
        ?int $quantity = null,
        ?string $idempotencyKey = null,
    ): UsageCheck {
        $response = $this->http->post(
            "/usage/check",
            HttpClient::buildBody([
                "customer_id" => $customerId,
                "feature_code" => $featureCode,
                "quantity" => $quantity,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid UsageCheck response payload");
        }

        return UsageCheck::fromArray($response->data);
    }

    /**
     * Track a usage event for a metered feature. Deducts from balance/credits if applicable.
     * @param TrackUsageParamsPropertiesItem[]|null $properties
     * @return UsageEvent
     */
    public function track(
        string $featureCode,
        string $customerId,
        ?string $eventId = null,
        ?string $timestamp = null,
        ?array $properties = null,
        ?string $model = null,
        ?int $inputTokens = null,
        ?int $outputTokens = null,
        ?float $value = null,
        ?int $cacheReadTokens = null,
        ?int $cacheWriteTokens = null,
        ?string $idempotencyKey = null,
    ): UsageEvent {
        $response = $this->http->post(
            "/usage/events",
            HttpClient::buildBody([
                "feature_code" => $featureCode,
                "customer_id" => $customerId,
                "event_id" => $eventId,
                "timestamp" => $timestamp,
                "properties" => $properties,
                "model" => $model,
                "input_tokens" => $inputTokens,
                "output_tokens" => $outputTokens,
                "value" => $value,
                "cache_read_tokens" => $cacheReadTokens,
                "cache_write_tokens" => $cacheWriteTokens,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid UsageEvent response payload");
        }

        return UsageEvent::fromArray($response->data);
    }

    /**
     * Set a metered feature's usage to an exact value for the current period. Use the Idempotency-Key header to make retries safe.
     * @return UsageAdjustment
     */
    public function set(
        string $customerId,
        string $featureCode,
        int $value,
        ?string $reason = null,
        ?string $idempotencyKey = null,
    ): UsageAdjustment {
        $response = $this->http->put(
            "/usage",
            HttpClient::buildBody([
                "customer_id" => $customerId,
                "feature_code" => $featureCode,
                "value" => $value,
                "reason" => $reason,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid UsageAdjustment response payload");
        }

        return UsageAdjustment::fromArray($response->data);
    }
}
