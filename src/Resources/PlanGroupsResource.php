<?php

declare(strict_types=1);

namespace Commet\Resources;

use Commet\ApiResponse;
use Commet\HttpClient;
use Commet\Models\PlanGroup;

class PlanGroupsResource
{
    public function __construct(
        private readonly HttpClient $http,
    ) {}

    /**
     * @return ApiResponse<PlanGroup[]>
     */
    public function list(
        ?int $limit = null,
        ?string $cursor = null,
    ): ApiResponse {
        $response = $this->http->get(
            '/plan-groups',
            HttpClient::buildBody([
                'limit' => $limit,
                'cursor' => $cursor,
            ]),
        );

        if ($response->success && is_array($response->data)) {
            $groups = array_map(
                fn(array $item) => PlanGroup::fromArray($item),
                $response->data,
            );

            return new ApiResponse(
                success: true,
                data: $groups,
                code: $response->code,
                message: $response->message,
                hasMore: $response->hasMore,
                nextCursor: $response->nextCursor,
            );
        }

        return $response;
    }

    /**
     * @return ApiResponse<PlanGroup>
     */
    public function get(string $id): ApiResponse
    {
        $response = $this->http->get("/plan-groups/{$id}");

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
     * @return ApiResponse<PlanGroup>
     */
    public function create(
        string $name,
        ?string $description = null,
        ?bool $isPublic = null,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        $response = $this->http->post(
            '/plan-groups',
            HttpClient::buildBody([
                'name' => $name,
                'description' => $description,
                'is_public' => $isPublic,
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
                'name' => $name,
                'description' => $description,
                'is_public' => $isPublic,
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
     * @return ApiResponse<void>
     */
    public function delete(
        string $id,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        return $this->http->delete("/plan-groups/{$id}", idempotencyKey: $idempotencyKey);
    }

    /**
     * @return ApiResponse<PlanGroup>
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
                'plan_id' => $planId,
                'sort_order' => $sortOrder,
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
     * @return ApiResponse<void>
     */
    public function removePlan(
        string $id,
        string $planId,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        return $this->http->delete("/plan-groups/{$id}/plans/{$planId}", idempotencyKey: $idempotencyKey);
    }

    /**
     * @param string[] $planIds
     * @return ApiResponse<PlanGroup>
     */
    public function reorderPlans(
        string $id,
        array $planIds,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        $response = $this->http->put(
            "/plan-groups/{$id}/plans/reorder",
            ['plan_ids' => $planIds],
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
}
