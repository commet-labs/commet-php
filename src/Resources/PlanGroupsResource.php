<?php

declare(strict_types=1);

namespace Commet\Resources;

use Commet\ApiResponse;
use Commet\HttpClient;
use Commet\Models\AddedPlanToGroup;
use Commet\Models\DeletedObject;
use Commet\Models\PlanGroup;
use Commet\Models\RemovedPlanFromGroup;
use Commet\Models\ReorderedPlans;

class PlanGroupsResource
{
    public function __construct(
        private readonly HttpClient $http,
    ) {}

    /**
     * List plan groups with cursor-based pagination.
     * @return ApiResponse<PlanGroup[]>
     */
    public function list(
        ?int $limit = null,
        ?string $cursor = null,
    ): ApiResponse {
        $response = $this->http->get(
            "/plan-groups",
            HttpClient::buildBody([
                "limit" => $limit,
                "cursor" => $cursor,
            ]),
        );

        if ($response->success && is_array($response->data)) {
            $items = array_map(
                fn(array $item) => PlanGroup::fromArray($item),
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
     * Retrieve a plan group by ID, including its plans ordered by sortOrder.
     * @return ApiResponse<PlanGroup>
     */
    public function get(
        string $id,
    ): ApiResponse {
        $response = $this->http->get(
            "/plan-groups/{$id}",
        );

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: PlanGroup::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }

    /**
     * Create a new plan group for organizing plans.
     * @return ApiResponse<PlanGroup>
     */
    public function create(
        string $name,
        ?string $description = null,
        ?bool $isPublic = null,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        $response = $this->http->post(
            "/plan-groups",
            HttpClient::buildBody([
                "name" => $name,
                "description" => $description,
                "is_public" => $isPublic,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: PlanGroup::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }

    /**
     * Update a plan group's name, description, or visibility.
     * @return ApiResponse<PlanGroup>
     */
    public function update(
        string $id,
        ?string $name = null,
        ?string $description = null,
        ?bool $isPublic = null,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        $response = $this->http->put(
            "/plan-groups/{$id}",
            HttpClient::buildBody([
                "name" => $name,
                "description" => $description,
                "is_public" => $isPublic,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: PlanGroup::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }

    /**
     * Delete a plan group. Plans in the group are unlinked, not deleted.
     * @return ApiResponse<DeletedObject>
     */
    public function delete(
        string $id,
    ): ApiResponse {
        $response = $this->http->delete(
            "/plan-groups/{$id}",
        );

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: DeletedObject::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }

    /**
     * Add an existing plan to a plan group with optional sort order.
     * @return ApiResponse<AddedPlanToGroup>
     */
    public function addPlan(
        string $id,
        string $planId,
        ?int $sortOrder = null,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        $response = $this->http->post(
            "/plan-groups/{$id}/plans",
            HttpClient::buildBody([
                "plan_id" => $planId,
                "sort_order" => $sortOrder,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: AddedPlanToGroup::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }

    /**
     * Remove a plan from a plan group.
     * @return ApiResponse<RemovedPlanFromGroup>
     */
    public function removePlan(
        string $id,
        string $planId,
    ): ApiResponse {
        $response = $this->http->delete(
            "/plan-groups/{$id}/plans/{$planId}",
        );

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: RemovedPlanFromGroup::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }

    /**
     * Set the display order of plans within a group. All plan IDs in the group must be provided.
     * @param string[] $planIds
     * @return ApiResponse<ReorderedPlans>
     */
    public function reorderPlans(
        string $id,
        array $planIds,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        $response = $this->http->put(
            "/plan-groups/{$id}/plans/reorder",
            HttpClient::buildBody([
                "plan_ids" => $planIds,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: ReorderedPlans::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }
}
