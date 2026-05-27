<?php

declare(strict_types=1);

namespace Commet\Resources;

use Commet\ApiResponse;
use Commet\HttpClient;
use Commet\Models\CreditPack;
use Commet\Models\CreditPackDetail;

class CreditPacksResource
{
    public function __construct(
        private readonly HttpClient $http,
    ) {}

    /**
     * @return ApiResponse<CreditPack[]>
     */
    public function list(): ApiResponse
    {
        $response = $this->http->get('/credit-packs');

        if ($response->success && is_array($response->data)) {
            $packs = array_map(
                fn(array $item) => CreditPack::fromArray($item),
                $response->data,
            );

            return new ApiResponse(
                success: true,
                data: $packs,
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }

    /**
     * @return ApiResponse<CreditPackDetail>
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
            '/credit-packs/manage',
            HttpClient::buildBody([
                'name' => $name,
                'credits' => $credits,
                'price' => $price,
                'description' => $description,
                'is_active' => $isActive,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: CreditPackDetail::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }

    /**
     * @return ApiResponse<CreditPackDetail>
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
                'name' => $name,
                'description' => $description,
                'credits' => $credits,
                'price' => $price,
                'is_active' => $isActive,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: CreditPackDetail::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }

    /**
     * @return ApiResponse<array{id: string, deleted: true}>
     */
    public function delete(
        string $id,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        return $this->http->delete("/credit-packs/{$id}", idempotencyKey: $idempotencyKey);
    }
}
