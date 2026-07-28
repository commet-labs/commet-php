<?php

declare(strict_types=1);

namespace Commet\Resources;

use Commet\HttpClient;
use Commet\Models\DeletedObject;
use Commet\Models\Feature;
use Commet\Models\FeaturesListResult;

class FeaturesResource
{
    public function __construct(
        private readonly HttpClient $http,
    ) {}

    /**
     * Get a single feature definition by code from the organization's feature catalog.
     * @return Feature
     */
    public function get(
        string $code,
    ): Feature {
        $response = $this->http->get(
            "/features/{$code}",
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid Feature response payload");
        }

        return Feature::fromArray($response->data);
    }

    /**
     * Update a feature's name, description, or unit name. At least one field must be provided.
     * @return Feature
     */
    public function update(
        string $code,
        ?string $name = null,
        ?string $description = null,
        ?string $unitName = null,
        ?string $idempotencyKey = null,
    ): Feature {
        $response = $this->http->patch(
            "/features/{$code}",
            HttpClient::buildBody([
                "name" => $name,
                "description" => $description,
                "unit_name" => $unitName,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid Feature response payload");
        }

        return Feature::fromArray($response->data);
    }

    /**
     * Delete a feature. Fails if the feature is attached to active plans or has an active add-on.
     * @return DeletedObject
     */
    public function delete(
        string $code,
    ): DeletedObject {
        $response = $this->http->delete(
            "/features/{$code}",
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid DeletedObject response payload");
        }

        return DeletedObject::fromArray($response->data);
    }

    /**
     * List every feature defined in the organization. This is the organization's feature catalog (definitions), not a customer's feature access.
     * @return FeaturesListResult
     */
    public function list(

    ): FeaturesListResult {
        $response = $this->http->get(
            "/features",
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid FeaturesListResult response payload");
        }

        return FeaturesListResult::fromArray($response->data);
    }

    /**
     * Create a new feature. Code must be lowercase alphanumeric with underscores.
     * @return Feature
     */
    public function create(
        string $name,
        string $code,
        string $type,
        ?string $description = null,
        ?string $unitName = null,
        ?string $idempotencyKey = null,
    ): Feature {
        $response = $this->http->post(
            "/features",
            HttpClient::buildBody([
                "name" => $name,
                "code" => $code,
                "type" => $type,
                "description" => $description,
                "unit_name" => $unitName,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid Feature response payload");
        }

        return Feature::fromArray($response->data);
    }
}
