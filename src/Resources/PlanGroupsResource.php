<?php

declare(strict_types=1);

namespace Commet\Resources;

use Commet\HttpClient;
use Commet\Models\AddedPlanToGroup;
use Commet\Models\DeletedObject;
use Commet\Models\PlanGroup;
use Commet\Models\PlanGroupDetail;
use Commet\Models\PlanGroupsListResult;
use Commet\Models\RemovedPlanFromGroup;
use Commet\Models\ReorderedPlans;

class PlanGroupsResource
{
    public function __construct(
        private readonly HttpClient $http,
    ) {}

    /**
     * Remove a plan from a plan group.
     * @return RemovedPlanFromGroup
     */
    public function removePlan(
        string $id,
        string $planId,
    ): RemovedPlanFromGroup {
        $response = $this->http->delete(
            "/plan-groups/{$id}/plans/{$planId}",
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid RemovedPlanFromGroup response payload");
        }

        return RemovedPlanFromGroup::fromArray($response->data);
    }

    /**
     * Set the display order of plans within a group. All plan IDs in the group must be provided.
     * @param string[] $planIds
     * @return ReorderedPlans
     */
    public function reorderPlans(
        string $id,
        array $planIds,
        ?string $idempotencyKey = null,
    ): ReorderedPlans {
        $response = $this->http->put(
            "/plan-groups/{$id}/plans/reorder",
            HttpClient::buildBody([
                "plan_ids" => $planIds,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid ReorderedPlans response payload");
        }

        return ReorderedPlans::fromArray($response->data);
    }

    /**
     * Add an existing plan to a plan group with optional sort order.
     * @return AddedPlanToGroup
     */
    public function addPlan(
        string $id,
        string $planId,
        ?int $sortOrder = null,
        ?string $idempotencyKey = null,
    ): AddedPlanToGroup {
        $response = $this->http->post(
            "/plan-groups/{$id}/plans",
            HttpClient::buildBody([
                "plan_id" => $planId,
                "sort_order" => $sortOrder,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid AddedPlanToGroup response payload");
        }

        return AddedPlanToGroup::fromArray($response->data);
    }

    /**
     * Retrieve a plan group by ID, including its plans ordered by sortOrder.
     * @return PlanGroupDetail
     */
    public function get(
        string $id,
    ): PlanGroupDetail {
        $response = $this->http->get(
            "/plan-groups/{$id}",
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid PlanGroupDetail response payload");
        }

        return PlanGroupDetail::fromArray($response->data);
    }

    /**
     * Update a plan group's name, description, or visibility.
     * @return PlanGroup
     */
    public function update(
        string $id,
        ?string $name = null,
        ?string $description = null,
        ?bool $isPublic = null,
        ?string $idempotencyKey = null,
    ): PlanGroup {
        $response = $this->http->patch(
            "/plan-groups/{$id}",
            HttpClient::buildBody([
                "name" => $name,
                "description" => $description,
                "is_public" => $isPublic,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid PlanGroup response payload");
        }

        return PlanGroup::fromArray($response->data);
    }

    /**
     * Delete a plan group. Plans in the group are unlinked, not deleted.
     * @return DeletedObject
     */
    public function delete(
        string $id,
    ): DeletedObject {
        $response = $this->http->delete(
            "/plan-groups/{$id}",
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid DeletedObject response payload");
        }

        return DeletedObject::fromArray($response->data);
    }

    /**
     * List plan groups with cursor-based pagination.
     * @return PlanGroupsListResult
     */
    public function list(
        ?string $cursor = null,
        ?int $limit = null,
    ): PlanGroupsListResult {
        $response = $this->http->get(
            "/plan-groups",
            HttpClient::buildBody([
                "cursor" => $cursor,
                "limit" => $limit,
            ]),
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid PlanGroupsListResult response payload");
        }

        return PlanGroupsListResult::fromArray($response->data);
    }

    /**
     * Create a new plan group for organizing plans.
     * @return PlanGroup
     */
    public function create(
        string $name,
        ?string $description = null,
        ?bool $isPublic = null,
        ?string $idempotencyKey = null,
    ): PlanGroup {
        $response = $this->http->post(
            "/plan-groups",
            HttpClient::buildBody([
                "name" => $name,
                "description" => $description,
                "is_public" => $isPublic,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid PlanGroup response payload");
        }

        return PlanGroup::fromArray($response->data);
    }
}
