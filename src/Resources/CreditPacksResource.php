<?php

declare(strict_types=1);

namespace Commet\Resources;

use Commet\ApiResponse;
use Commet\HttpClient;
use Commet\Models\CreditPack;
use Commet\Models\DeletedObject;

class CreditPacksResource
{
    public function __construct(
        private readonly HttpClient $http,
    ) {}

    /**
     * List all active credit packs.
     * @return ApiResponse<CreditPack[]>
     */
    public function list(

    ): ApiResponse {
        $response = $this->http->get(
            "/credit-packs",
        );

        if ($response->success && is_array($response->data)) {
            $items = array_map(
                fn(array $item) => CreditPack::fromArray($item),
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
     * Create a new credit pack.
     * @return ApiResponse<CreditPack>
     */
    public function create(
        string $name,
        int $credits,
        int $price,
        ?string $description = null,
        ?bool $isActive = null,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        $response = $this->http->post(
            "/credit-packs/manage",
            HttpClient::buildBody([
                "name" => $name,
                "description" => $description,
                "credits" => $credits,
                "price" => $price,
                "is_active" => $isActive,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: CreditPack::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }

    /**
     * Update a credit pack's name, description, credits, price, or active status.
     * @return ApiResponse<CreditPack>
     */
    public function update(
        string $id,
        ?string $name = null,
        ?string $description = null,
        ?int $credits = null,
        ?int $price = null,
        ?bool $isActive = null,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        $response = $this->http->put(
            "/credit-packs/{$id}",
            HttpClient::buildBody([
                "name" => $name,
                "description" => $description,
                "credits" => $credits,
                "price" => $price,
                "is_active" => $isActive,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: CreditPack::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }

    /**
     * Soft-delete a credit pack.
     * @return ApiResponse<DeletedObject>
     */
    public function delete(
        string $id,
    ): ApiResponse {
        $response = $this->http->delete(
            "/credit-packs/{$id}",
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
}
