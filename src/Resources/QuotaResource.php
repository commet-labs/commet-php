<?php

declare(strict_types=1);

namespace Commet\Resources;

use Commet\HttpClient;
use Commet\Models\QuotaGetAllResult;
use Commet\Models\UsageQuota;
use Commet\Models\UsageQuotaEvent;

class QuotaResource
{
    public function __construct(
        private readonly HttpClient $http,
    ) {}

    /**
     * Get all quota allowances for a customer across every quota feature in their plan.
     * @return QuotaGetAllResult
     */
    public function getAll(
        string $customerId,
    ): QuotaGetAllResult {
        $response = $this->http->get(
            "/usage/quota/all",
            HttpClient::buildBody([
                "customer_id" => $customerId,
            ]),
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid QuotaGetAllResult response payload");
        }

        return QuotaGetAllResult::fromArray($response->data);
    }

    /**
     * Remove from a customer's quota allowance for a feature. Defaults to 1 if count is omitted. Returns 400 insufficient_balance if the balance would go negative.
     * @return UsageQuotaEvent
     */
    public function remove(
        string $featureCode,
        ?int $count = null,
        ?string $customerId = null,
        ?string $externalId = null,
        ?string $idempotencyKey = null,
    ): UsageQuotaEvent {
        $response = $this->http->post(
            "/usage/quota/remove",
            HttpClient::buildBody([
                "feature_code" => $featureCode,
                "count" => $count,
                "customer_id" => $customerId,
                "external_id" => $externalId,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid UsageQuotaEvent response payload");
        }

        return UsageQuotaEvent::fromArray($response->data);
    }

    /**
     * Get the current quota allowance (used vs included) for a specific feature.
     * @return UsageQuota
     */
    public function get(
        string $customerId,
        string $featureCode,
    ): UsageQuota {
        $response = $this->http->get(
            "/usage/quota",
            HttpClient::buildBody([
                "customer_id" => $customerId,
                "feature_code" => $featureCode,
            ]),
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid UsageQuota response payload");
        }

        return UsageQuota::fromArray($response->data);
    }

    /**
     * Add to a customer's quota allowance for a feature. Defaults to 1 if count is omitted.
     * @return UsageQuotaEvent
     */
    public function add(
        string $featureCode,
        ?int $count = null,
        ?string $customerId = null,
        ?string $externalId = null,
        ?string $idempotencyKey = null,
    ): UsageQuotaEvent {
        $response = $this->http->post(
            "/usage/quota",
            HttpClient::buildBody([
                "feature_code" => $featureCode,
                "count" => $count,
                "customer_id" => $customerId,
                "external_id" => $externalId,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid UsageQuotaEvent response payload");
        }

        return UsageQuotaEvent::fromArray($response->data);
    }

    /**
     * Set a customer's quota allowance for a feature to an exact value.
     * @return UsageQuotaEvent
     */
    public function set(
        string $featureCode,
        int $count,
        ?string $customerId = null,
        ?string $externalId = null,
        ?string $idempotencyKey = null,
    ): UsageQuotaEvent {
        $response = $this->http->put(
            "/usage/quota",
            HttpClient::buildBody([
                "feature_code" => $featureCode,
                "count" => $count,
                "customer_id" => $customerId,
                "external_id" => $externalId,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid UsageQuotaEvent response payload");
        }

        return UsageQuotaEvent::fromArray($response->data);
    }
}
