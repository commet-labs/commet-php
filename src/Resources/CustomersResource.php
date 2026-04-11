<?php

declare(strict_types=1);

namespace Commet\Resources;

use Commet\ApiResponse;
use Commet\HttpClient;
use Commet\Models\Customer;

class CustomersResource
{
    public function __construct(
        private readonly HttpClient $http,
    ) {}

    /**
     * @param array<string, mixed>|null $metadata
     * @param array<string, string>|null $address
     * @return ApiResponse<Customer>
     */
    public function create(
        string $email,
        ?string $id = null,
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
        $response = $this->http->post(
            '/customers',
            HttpClient::buildBody([
                'billing_email' => $email,
                'external_id' => $id,
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

        return self::toTyped($response);
    }

    /**
     * @param list<array<string, mixed>> $customers
     * @return ApiResponse<array{successful: Customer[], failed: array<int, array{index: int, error: string}>}>
     */
    public function createBatch(
        array $customers,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        $mapped = array_map(fn(array $customer) => HttpClient::buildBody([
            'billing_email' => $customer['email'] ?? null,
            'external_id' => $customer['id'] ?? null,
            'full_name' => $customer['full_name'] ?? null,
            'domain' => $customer['domain'] ?? null,
            'website' => $customer['website'] ?? null,
            'timezone' => $customer['timezone'] ?? null,
            'language' => $customer['language'] ?? null,
            'industry' => $customer['industry'] ?? null,
            'metadata' => $customer['metadata'] ?? null,
            'address' => $customer['address'] ?? null,
        ]), $customers);

        $response = $this->http->post(
            '/customers/batch',
            ['customers' => $mapped],
            idempotencyKey: $idempotencyKey,
        );

        if ($response->success && is_array($response->data)) {
            $successful = array_map(
                fn(array $c) => Customer::fromArray($c),
                $response->data['successful'] ?? [],
            );

            return new ApiResponse(
                success: true,
                data: [
                    'successful' => $successful,
                    'failed' => $response->data['failed'] ?? [],
                ],
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }

    /**
     * @return ApiResponse<Customer>
     */
    public function get(string $customerId): ApiResponse
    {
        return self::toTyped($this->http->get("/customers/{$customerId}"));
    }

    /**
     * @param array<string, mixed>|null $metadata
     * @param array<string, string>|null $address
     * @return ApiResponse<Customer>
     */
    public function update(
        string $customerId,
        ?string $email = null,
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
        $response = $this->http->put(
            "/customers/{$customerId}",
            HttpClient::buildBody([
                'billing_email' => $email,
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

        return self::toTyped($response);
    }

    /**
     * @return ApiResponse<Customer[]>
     */
    public function list(
        ?string $customerId = null,
        ?bool $isActive = null,
        ?string $search = null,
        ?int $limit = null,
        ?string $cursor = null,
    ): ApiResponse {
        $response = $this->http->get(
            '/customers',
            HttpClient::buildBody([
                'customer_id' => $customerId,
                'is_active' => $isActive,
                'search' => $search,
                'limit' => $limit,
                'cursor' => $cursor,
            ]),
        );

        if ($response->success && is_array($response->data)) {
            $customers = array_map(
                fn(array $item) => Customer::fromArray($item),
                $response->data,
            );

            return new ApiResponse(
                success: true,
                data: $customers,
                code: $response->code,
                message: $response->message,
                hasMore: $response->hasMore,
                nextCursor: $response->nextCursor,
            );
        }

        return $response;
    }

    /**
     * @return ApiResponse<Customer>
     */
    public function archive(string $customerId, ?string $idempotencyKey = null): ApiResponse
    {
        return self::toTyped(
            $this->http->put(
                "/customers/{$customerId}",
                ['is_active' => false],
                idempotencyKey: $idempotencyKey,
            ),
        );
    }

    /**
     * @return ApiResponse<Customer>
     */
    private static function toTyped(ApiResponse $response): ApiResponse
    {
        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: Customer::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }
}
