<?php

declare(strict_types=1);

namespace Commet\Resources;

use Commet\HttpClient;
use Commet\Models\Addon;
use Commet\Models\AddonsListActiveResult;
use Commet\Models\AddonsListResult;
use Commet\Models\DeletedObject;

class AddonsResource
{
    public function __construct(
        private readonly HttpClient $http,
    ) {}

    /**
     * List all active add-ons for a customer's subscription.
     * @return AddonsListActiveResult
     */
    public function listActive(
        string $customerId,
    ): AddonsListActiveResult {
        $response = $this->http->get(
            "/active-addons",
            HttpClient::buildBody([
                "customer_id" => $customerId,
            ]),
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid AddonsListActiveResult response payload");
        }

        return AddonsListActiveResult::fromArray($response->data);
    }

    /**
     * Retrieve an add-on by its public ID or slug.
     * @return Addon
     */
    public function get(
        string $id,
    ): Addon {
        $response = $this->http->get(
            "/addons/{$id}",
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid Addon response payload");
        }

        return Addon::fromArray($response->data);
    }

    /**
     * Update an add-on's name, description, or pricing.
     * @return Addon
     */
    public function update(
        string $id,
        ?string $name = null,
        ?string $description = null,
        ?int $basePrice = null,
        ?int $includedUnits = null,
        ?int $overageRate = null,
        ?string $idempotencyKey = null,
    ): Addon {
        $response = $this->http->patch(
            "/addons/{$id}",
            HttpClient::buildBody([
                "name" => $name,
                "description" => $description,
                "base_price" => $basePrice,
                "included_units" => $includedUnits,
                "overage_rate" => $overageRate,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid Addon response payload");
        }

        return Addon::fromArray($response->data);
    }

    /**
     * Soft-delete an add-on. Fails if the add-on has active subscriptions.
     * @return DeletedObject
     */
    public function delete(
        string $id,
    ): DeletedObject {
        $response = $this->http->delete(
            "/addons/{$id}",
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid DeletedObject response payload");
        }

        return DeletedObject::fromArray($response->data);
    }

    /**
     * List all add-ons with cursor-based pagination.
     * @return AddonsListResult
     */
    public function list(
        ?string $cursor = null,
        ?int $limit = null,
    ): AddonsListResult {
        $response = $this->http->get(
            "/addons",
            HttpClient::buildBody([
                "cursor" => $cursor,
                "limit" => $limit,
            ]),
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid AddonsListResult response payload");
        }

        return AddonsListResult::fromArray($response->data);
    }

    /**
     * Create a new add-on linked to a feature. Each feature can only be assigned to one add-on.
     * @return Addon
     */
    public function create(
        string $name,
        int $basePrice,
        string $featureId,
        string $consumptionModel,
        ?string $description = null,
        ?int $includedUnits = null,
        ?int $overageRate = null,
        ?int $creditCost = null,
        ?string $idempotencyKey = null,
    ): Addon {
        $response = $this->http->post(
            "/addons",
            HttpClient::buildBody([
                "name" => $name,
                "description" => $description,
                "base_price" => $basePrice,
                "feature_id" => $featureId,
                "consumption_model" => $consumptionModel,
                "included_units" => $includedUnits,
                "overage_rate" => $overageRate,
                "credit_cost" => $creditCost,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid Addon response payload");
        }

        return Addon::fromArray($response->data);
    }
}
