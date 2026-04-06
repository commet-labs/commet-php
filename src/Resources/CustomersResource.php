<?php

declare(strict_types=1);

namespace Commet\Resources;

use Commet\ApiResponse;
use Commet\HttpClient;

class CustomersResource
{
    public function __construct(
        private readonly HttpClient $http,
    ) {}

    /**
     * @param array<string, mixed>|null $metadata
     * @param array<string, string>|null $address
     */
    public function create(
        string $email,
        ?string $externalId = null,
        ?string $fullName = null,
        ?string $domain = null,
        ?string $website = null,
        ?string $timezone = null,
        ?string $language = null,
        ?string $industry = null,
        ?array $metadata = null,
        ?array $address = null,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        return $this->http->post(
            '/customers',
            HttpClient::buildBody([
                'billing_email' => $email,
                'external_id' => $externalId,
                'full_name' => $fullName,
                'domain' => $domain,
                'website' => $website,
                'timezone' => $timezone,
                'language' => $language,
                'industry' => $industry,
                'metadata' => $metadata,
                'address' => $address,
            ]),
            idempotencyKey: $idempotencyKey,
        );
    }

    /**
     * @param list<array<string, mixed>> $customers
     */
    public function createBatch(
        array $customers,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        $mapped = array_map(fn(array $customer) => HttpClient::buildBody([
            'billing_email' => $customer['email'] ?? null,
            'external_id' => $customer['external_id'] ?? null,
            'full_name' => $customer['full_name'] ?? null,
            'domain' => $customer['domain'] ?? null,
            'website' => $customer['website'] ?? null,
            'timezone' => $customer['timezone'] ?? null,
            'language' => $customer['language'] ?? null,
            'industry' => $customer['industry'] ?? null,
            'metadata' => $customer['metadata'] ?? null,
            'address' => $customer['address'] ?? null,
        ]), $customers);

        return $this->http->post(
            '/customers/batch',
            ['customers' => $mapped],
            idempotencyKey: $idempotencyKey,
        );
    }

    public function get(string $customerId): ApiResponse
    {
        return $this->http->get("/customers/{$customerId}");
    }

    /**
     * @param array<string, mixed>|null $metadata
     */
    public function update(
        string $customerId,
        ?string $email = null,
        ?string $externalId = null,
        ?string $fullName = null,
        ?string $domain = null,
        ?string $website = null,
        ?string $timezone = null,
        ?string $language = null,
        ?string $industry = null,
        ?array $metadata = null,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        return $this->http->put(
            "/customers/{$customerId}",
            HttpClient::buildBody([
                'billing_email' => $email,
                'external_id' => $externalId,
                'full_name' => $fullName,
                'domain' => $domain,
                'website' => $website,
                'timezone' => $timezone,
                'language' => $language,
                'industry' => $industry,
                'metadata' => $metadata,
            ]),
            idempotencyKey: $idempotencyKey,
        );
    }

    public function list(
        ?string $externalId = null,
        ?bool $isActive = null,
        ?string $search = null,
        ?int $limit = null,
        ?string $cursor = null,
    ): ApiResponse {
        return $this->http->get(
            '/customers',
            HttpClient::buildBody([
                'external_id' => $externalId,
                'is_active' => $isActive,
                'search' => $search,
                'limit' => $limit,
                'cursor' => $cursor,
            ]),
        );
    }

    public function archive(string $customerId, ?string $idempotencyKey = null): ApiResponse
    {
        return $this->http->put(
            "/customers/{$customerId}",
            ['is_active' => false],
            idempotencyKey: $idempotencyKey,
        );
    }
}
