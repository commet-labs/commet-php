<?php

declare(strict_types=1);

namespace Commet\Resources;

use Commet\ApiResponse;
use Commet\Enums\InvoiceStatus;
use Commet\HttpClient;
use Commet\Models\Invoice;
use Commet\Models\InvoiceDownloadResult;
use Commet\Models\InvoiceSendResult;
use Commet\Models\InvoiceStatusResult;

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
        ?InvoiceStatus $status = null,
        ?string $subscriptionId = null,
        ?int $limit = null,
        ?string $cursor = null,
    ): ApiResponse {
        $response = $this->http->get(
            '/invoices',
            HttpClient::buildBody([
                'customer_id' => $customerId,
                'status' => $status?->value,
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
     * Signed URL, expires after 7 days.
     *
     * @return ApiResponse<InvoiceDownloadResult>
     */
    public function getDownloadUrl(string $id): ApiResponse
    {
        $response = $this->http->get("/invoices/{$id}/download");

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: InvoiceDownloadResult::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }

    /**
     * @return ApiResponse<InvoiceSendResult>
     */
    public function send(
        string $id,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        $response = $this->http->post("/invoices/{$id}/send", [], idempotencyKey: $idempotencyKey);

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: InvoiceSendResult::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }

    /**
     * Only outstanding invoices can be changed to paid or void.
     *
     * @return ApiResponse<InvoiceStatusResult>
     */
    public function updateStatus(
        string $id,
        InvoiceStatus $status,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        $response = $this->http->put(
            "/invoices/{$id}/status",
            ['status' => $status->value],
            idempotencyKey: $idempotencyKey,
        );

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: InvoiceStatusResult::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }
}
