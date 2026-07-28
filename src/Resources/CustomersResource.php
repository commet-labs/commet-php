<?php

declare(strict_types=1);

namespace Commet\Resources;

use Commet\Enums\Timezone;
use Commet\HttpClient;
use Commet\Models\BatchCreateCustomersParamsCustomersItem;
use Commet\Models\CreateCustomerParamsAddress;
use Commet\Models\Customer;
use Commet\Models\CustomerBatch;
use Commet\Models\CustomersListResult;
use Commet\Models\UpdateCustomerParamsAddress;

class CustomersResource
{
    public function __construct(
        private readonly HttpClient $http,
    ) {}

    /**
     * Retrieve a customer by their public ID, including subscription status and metadata.
     * @return Customer
     */
    public function get(
        string $id,
    ): Customer {
        $response = $this->http->get(
            "/customers/{$id}",
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid Customer response payload");
        }

        return Customer::fromArray($response->data);
    }

    /**
     * Update a customer's name, external ID, or metadata.
     * @param array<string, mixed>|null $metadata
     * @return Customer
     */
    public function update(
        string $id,
        ?string $email = null,
        ?string $fullName = null,
        ?string $taxDocument = null,
        ?string $externalId = null,
        ?Timezone $timezone = null,
        ?array $metadata = null,
        ?UpdateCustomerParamsAddress $address = null,
        ?string $idempotencyKey = null,
    ): Customer {
        $response = $this->http->patch(
            "/customers/{$id}",
            HttpClient::buildBody([
                "email" => $email,
                "full_name" => $fullName,
                "tax_document" => $taxDocument,
                "external_id" => $externalId,
                "timezone" => $timezone?->value,
                "metadata" => $metadata,
                "address" => $address,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid Customer response payload");
        }

        return Customer::fromArray($response->data);
    }

    /**
     * Create up to 100 customers in a single request.
     * @param BatchCreateCustomersParamsCustomersItem[] $customers
     * @return CustomerBatch
     */
    public function createBatch(
        array $customers,
        ?string $idempotencyKey = null,
    ): CustomerBatch {
        $response = $this->http->post(
            "/customers/batch",
            HttpClient::buildBody([
                "customers" => $customers,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid CustomerBatch response payload");
        }

        return CustomerBatch::fromArray($response->data);
    }

    /**
     * List customers with cursor-based pagination.
     * @return CustomersListResult
     */
    public function list(
        ?string $cursor = null,
        ?int $limit = null,
        ?string $externalId = null,
    ): CustomersListResult {
        $response = $this->http->get(
            "/customers",
            HttpClient::buildBody([
                "cursor" => $cursor,
                "limit" => $limit,
                "external_id" => $externalId,
            ]),
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid CustomersListResult response payload");
        }

        return CustomersListResult::fromArray($response->data);
    }

    /**
     * Create a new customer. Idempotent when customerId is provided.
     * @param array<string, mixed>|null $metadata
     * @return Customer
     */
    public function create(
        string $email,
        ?string $id = null,
        ?string $externalId = null,
        ?string $fullName = null,
        ?string $taxDocument = null,
        ?CreateCustomerParamsAddress $address = null,
        ?string $addressId = null,
        ?Timezone $timezone = null,
        ?array $metadata = null,
        ?string $idempotencyKey = null,
    ): Customer {
        $response = $this->http->post(
            "/customers",
            HttpClient::buildBody([
                "id" => $id,
                "external_id" => $externalId,
                "full_name" => $fullName,
                "tax_document" => $taxDocument,
                "address" => $address,
                "address_id" => $addressId,
                "email" => $email,
                "timezone" => $timezone?->value,
                "metadata" => $metadata,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid Customer response payload");
        }

        return Customer::fromArray($response->data);
    }
}
