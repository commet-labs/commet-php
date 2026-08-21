<?php

declare(strict_types=1);

namespace Commet\Resources;

use Commet\Enums\Timezone;
use Commet\HttpClient;
use Commet\Models\BatchCreateCustomersParamsCustomersItem;
use Commet\Models\CreateCustomerParamsAddress;
use Commet\Models\Customer;
use Commet\Models\CustomerBatch;
use Commet\Models\CustomerCredit;
use Commet\Models\CustomerCreditRevocation;
use Commet\Models\CustomersListCreditsResult;
use Commet\Models\CustomersListPlanGrantsResult;
use Commet\Models\CustomersListResult;
use Commet\Models\PlanGrant;
use Commet\Models\UpdateCustomerParamsAddress;

class CustomersResource
{
    public function __construct(
        private readonly HttpClient $http,
    ) {}

    /**
     * Revoke the unallocated remainder of a customer credit grant. Applied invoice history is unchanged.
     * @return CustomerCreditRevocation
     */
    public function revokeCredit(
        string $id,
        string $creditId,
        ?string $idempotencyKey = null,
    ): CustomerCreditRevocation {
        $response = $this->http->post(
            "/customers/{$id}/credits/{$creditId}/revoke",
            idempotencyKey: $idempotencyKey,
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid CustomerCreditRevocation response payload");
        }

        return CustomerCreditRevocation::fromArray($response->data);
    }

    /**
     * List currency-specific invoice credit grants and their remaining balances for a customer.
     * @return CustomersListCreditsResult
     */
    public function listCredits(
        string $id,
    ): CustomersListCreditsResult {
        $response = $this->http->get(
            "/customers/{$id}/credits",
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid CustomersListCreditsResult response payload");
        }

        return CustomersListCreditsResult::fromArray($response->data);
    }

    /**
     * Grant monetary credit in one currency. Credit is applied FIFO before tax to eligible recurring invoices.
     * @return CustomerCredit
     */
    public function createCredit(
        string $id,
        int $amount,
        string $currency,
        string $reason,
        ?string $expiresAt = null,
        ?string $idempotencyKey = null,
    ): CustomerCredit {
        $response = $this->http->post(
            "/customers/{$id}/credits",
            HttpClient::buildBody([
                "amount" => $amount,
                "currency" => $currency,
                "reason" => $reason,
                "expires_at" => $expiresAt,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid CustomerCredit response payload");
        }

        return CustomerCredit::fromArray($response->data);
    }

    /**
     * End expanded access immediately and restore the base plan's limits. The subscription, billing cycle, invoices, and payment state remain unchanged.
     * @return PlanGrant
     */
    public function revokePlanGrant(
        string $id,
        string $grantId,
        string $reason,
        ?string $idempotencyKey = null,
    ): PlanGrant {
        $response = $this->http->post(
            "/customers/{$id}/plan-grants/{$grantId}/revoke",
            HttpClient::buildBody([
                "reason" => $reason,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid PlanGrant response payload");
        }

        return PlanGrant::fromArray($response->data);
    }

    /**
     * Keep the overlay for a number of the subscription's existing billing cycles, set an exact deadline, or leave it active until revoked. The billing anchor is never reset.
     * @return PlanGrant
     */
    public function updatePlanGrant(
        string $id,
        string $grantId,
        string $reason,
        string $duration,
        ?int $durationCycles = null,
        ?string $expiresAt = null,
        ?string $idempotencyKey = null,
    ): PlanGrant {
        $response = $this->http->patch(
            "/customers/{$id}/plan-grants/{$grantId}",
            HttpClient::buildBody([
                "reason" => $reason,
                "duration" => $duration,
                "duration_cycles" => $durationCycles,
                "expires_at" => $expiresAt,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid PlanGrant response payload");
        }

        return PlanGrant::fromArray($response->data);
    }

    /**
     * List the independent audit timeline for paid-plan access granted without checkout or payment credentials.
     * @return CustomersListPlanGrantsResult
     */
    public function listPlanGrants(
        string $id,
    ): CustomersListPlanGrantsResult {
        $response = $this->http->get(
            "/customers/{$id}/plan-grants",
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid CustomersListPlanGrantsResult response payload");
        }

        return CustomersListPlanGrantsResult::fromArray($response->data);
    }

    /**
     * Temporarily expand an active subscription's feature access using a higher plan in the same plan group. Billing, prices, periods, invoices, and the base subscription remain unchanged.
     * @return PlanGrant
     */
    public function createPlanGrant(
        string $id,
        string $subscriptionId,
        string $planId,
        string $reason,
        string $duration,
        ?int $durationCycles = null,
        ?string $expiresAt = null,
        ?string $idempotencyKey = null,
    ): PlanGrant {
        $response = $this->http->post(
            "/customers/{$id}/plan-grants",
            HttpClient::buildBody([
                "subscription_id" => $subscriptionId,
                "plan_id" => $planId,
                "reason" => $reason,
                "duration" => $duration,
                "duration_cycles" => $durationCycles,
                "expires_at" => $expiresAt,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid PlanGrant response payload");
        }

        return PlanGrant::fromArray($response->data);
    }

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
