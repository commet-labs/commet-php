<?php

declare(strict_types=1);

namespace Commet\Resources;

use Commet\ApiResponse;
use Commet\Enums\Timezone;
use Commet\HttpClient;
use Commet\Models\Customer;
use Commet\Models\CustomerBatch;

class CustomersResource
{
    public function __construct(
        private readonly HttpClient $http,
    ) {}

    /**
     * List customers with cursor-based pagination.
     * @return ApiResponse<Customer[]>
     */
    public function list(
        ?string $externalId = null,
        ?int $limit = null,
        ?string $cursor = null,
    ): ApiResponse {
        $response = $this->http->get(
            "/customers",
            HttpClient::buildBody([
                "external_id" => $externalId,
                "limit" => $limit,
                "cursor" => $cursor,
            ]),
        );

        if ($response->success && is_array($response->data)) {
            $items = array_map(
                fn(array $item) => Customer::fromArray($item),
                $response->data,
            );

            return new ApiResponse(
                success: true,
                data: $items,
                code: $response->code,
                message: $response->message,
                hasMore: $response->hasMore,
                nextCursor: $response->nextCursor,
            );
        }

        return $response;
    }

    /**
     * Create a new customer. Idempotent when customerId is provided.
     * @param array<string, mixed>|null $address
     * @param array<string, mixed>|null $metadata
     * @return ApiResponse<Customer>
     */
    public function create(
        string $email,
        ?string $id = null,
        ?string $externalId = null,
        ?string $fullName = null,
        ?array $address = null,
        ?string $addressId = null,
        ?Timezone $timezone = null,
        ?array $metadata = null,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        $response = $this->http->post(
            "/customers",
            HttpClient::buildBody([
                "id" => $id,
                "external_id" => $externalId,
                "full_name" => $fullName,
                "address" => $address,
                "address_id" => $addressId,
                "email" => $email,
                "timezone" => $timezone?->value,
                "metadata" => $metadata,
            ]),
            idempotencyKey: $idempotencyKey,
        );

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

    /**
     * Retrieve a customer by their public ID, including subscription status and metadata.
     * @return ApiResponse<Customer>
     */
    public function get(
        string $id,
    ): ApiResponse {
        $response = $this->http->get(
            "/customers/{$id}",
        );

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

    /**
     * Update a customer's name, external ID, or metadata.
     * @param array<string, mixed>|null $metadata
     * @param array<string, mixed>|null $address
     * @return ApiResponse<Customer>
     */
    public function update(
        string $id,
        ?string $email = null,
        ?string $fullName = null,
        ?string $externalId = null,
        ?Timezone $timezone = null,
        ?array $metadata = null,
        ?array $address = null,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        $response = $this->http->put(
            "/customers/{$id}",
            HttpClient::buildBody([
                "email" => $email,
                "full_name" => $fullName,
                "external_id" => $externalId,
                "timezone" => $timezone?->value,
                "metadata" => $metadata,
                "address" => $address,
            ]),
            idempotencyKey: $idempotencyKey,
        );

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

    /**
     * Create up to 100 customers in a single request.
     * @param list<array<string, mixed>> $customers
     * @return ApiResponse<CustomerBatch>
     */
    public function createBatch(
        array $customers,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        $response = $this->http->post(
            "/customers/batch",
            HttpClient::buildBody([
                "customers" => $customers,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: CustomerBatch::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }
}
