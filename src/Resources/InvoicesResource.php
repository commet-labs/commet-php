<?php

declare(strict_types=1);

namespace Commet\Resources;

use Commet\ApiResponse;
use Commet\HttpClient;
use Commet\Models\CreatedInvoice;
use Commet\Models\Invoice;
use Commet\Models\InvoiceDownload;
use Commet\Models\InvoiceStatus;
use Commet\Models\SentInvoice;

class InvoicesResource
{
    public function __construct(
        private readonly HttpClient $http,
    ) {}

    /**
     * List invoices with cursor-based pagination. Filter by customer, status, or subscription.
     * @return ApiResponse<Invoice[]>
     */
    public function list(
        ?string $customerId = null,
        ?string $status = null,
        ?string $subscriptionId = null,
        ?string $cursor = null,
        ?int $limit = null,
    ): ApiResponse {
        $response = $this->http->get(
            "/invoices",
            HttpClient::buildBody([
                "customer_id" => $customerId,
                "status" => $status,
                "subscription_id" => $subscriptionId,
                "cursor" => $cursor,
                "limit" => $limit,
            ]),
        );

        if ($response->success && is_array($response->data)) {
            $items = array_map(
                fn(array $item) => Invoice::fromArray($item),
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
     * Retrieve a single invoice by its public ID, including line items.
     * @return ApiResponse<Invoice>
     */
    public function get(
        string $id,
    ): ApiResponse {
        $response = $this->http->get(
            "/invoices/{$id}",
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
     * Create a one-off adjustment invoice. Use a negative amount for a credit.
     * @param array<string, mixed>|null $metadata
     * @return ApiResponse<CreatedInvoice>
     */
    public function createAdjustment(
        string $customerId,
        int $amount,
        string $description,
        ?array $metadata = null,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        $response = $this->http->post(
            "/invoices",
            HttpClient::buildBody([
                "customer_id" => $customerId,
                "amount" => $amount,
                "description" => $description,
                "metadata" => $metadata,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: CreatedInvoice::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }

    /**
     * Generate a signed URL to download the invoice as a PDF. The URL expires after 7 days.
     * @return ApiResponse<InvoiceDownload>
     */
    public function getDownloadUrl(
        string $id,
    ): ApiResponse {
        $response = $this->http->get(
            "/invoices/{$id}/download",
        );

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: InvoiceDownload::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }

    /**
     * Send the invoice to the customer via email.
     * @return ApiResponse<SentInvoice>
     */
    public function send(
        string $id,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        $response = $this->http->post(
            "/invoices/{$id}/send",
            idempotencyKey: $idempotencyKey,
        );

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: SentInvoice::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }

    /**
     * Mark an outstanding invoice as "paid" or "void". Cannot change the status of already paid or voided invoices.
     * @return ApiResponse<InvoiceStatus>
     */
    public function updateStatus(
        string $id,
        string $status,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        $response = $this->http->put(
            "/invoices/{$id}/status",
            HttpClient::buildBody([
                "status" => $status,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: InvoiceStatus::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }
}
