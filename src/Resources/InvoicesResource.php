<?php

declare(strict_types=1);

namespace Commet\Resources;

use Commet\ApiResponse;
use Commet\HttpClient;
use Commet\Models\Invoice;

class InvoicesResource
{
    public function __construct(
        private readonly HttpClient $http,
    ) {}

    /**
     * @return ApiResponse<Invoice[]>
     */
    public function list(
        ?string $customerId = null,
        ?string $status = null,
        ?string $subscriptionId = null,
        ?int $limit = null,
        ?string $cursor = null,
    ): ApiResponse {
        $response = $this->http->get(
            '/invoices',
            HttpClient::buildBody([
                'customer_id' => $customerId,
                'status' => $status,
                'subscription_id' => $subscriptionId,
                'limit' => $limit,
                'cursor' => $cursor,
            ]),
        );

        if ($response->success && is_array($response->data)) {
            $invoices = array_map(
                fn(array $item) => Invoice::fromArray($item),
                $response->data,
            );

            return new ApiResponse(
                success: true,
                data: $invoices,
                code: $response->code,
                message: $response->message,
                hasMore: $response->hasMore,
                nextCursor: $response->nextCursor,
            );
        }

        return $response;
    }

    /**
     * @return ApiResponse<Invoice>
     */
    public function get(string $id): ApiResponse
    {
        $response = $this->http->get("/invoices/{$id}");

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: Invoice::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }

    /**
     * @param array<string, mixed>|null $metadata
     * @return ApiResponse<Invoice>
     */
    public function createAdjustment(
        string $customerId,
        int $amount,
        ?string $description = null,
        ?array $metadata = null,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        $response = $this->http->post(
            '/invoices',
            HttpClient::buildBody([
                'customer_id' => $customerId,
                'amount' => $amount,
                'description' => $description,
                'metadata' => $metadata,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: Invoice::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }

    /**
     * @return ApiResponse<array{url: string, expires_at: string}>
     */
    public function getDownloadUrl(string $id): ApiResponse
    {
        return $this->http->get("/invoices/{$id}/download");
    }

    /**
     * @return ApiResponse<array{sent: bool, sent_at: string}>
     */
    public function send(
        string $id,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        return $this->http->post("/invoices/{$id}/send", [], idempotencyKey: $idempotencyKey);
    }

    /**
     * @return ApiResponse<array{id: string, status: string, updated_at: string}>
     */
    public function updateStatus(
        string $id,
        string $status,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        return $this->http->put(
            "/invoices/{$id}/status",
            ['status' => $status],
            idempotencyKey: $idempotencyKey,
        );
    }
}
