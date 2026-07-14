<?php

declare(strict_types=1);

namespace Commet\Resources;

use Commet\ApiResponse;
use Commet\HttpClient;
use Commet\Models\Payment;

class PaymentsResource
{
    public function __construct(
        private readonly HttpClient $http,
    ) {}

    /**
     * List payments with cursor-based pagination. Filter by customer.
     * @return ApiResponse<Payment[]>
     */
    public function list(
        ?string $customerId = null,
        ?string $cursor = null,
        ?int $limit = null,
    ): ApiResponse {
        $response = $this->http->get(
            "/payments",
            HttpClient::buildBody([
                "customer_id" => $customerId,
                "cursor" => $cursor,
                "limit" => $limit,
            ]),
        );

        if ($response->success && is_array($response->data)) {
            $items = array_map(
                fn(array $item) => Payment::fromArray($item),
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
     * Create a hosted payment link. Returns a url the customer opens to pay with any card. Calculates tax, generates an invoice, and vaults the payment method on confirmation. No subscription or plan required.
     * @param array<string, string>|null $metadata
     * @return ApiResponse<Payment>
     */
    public function create(
        int $amount,
        string $currency,
        string $description,
        ?string $customerId = null,
        ?string $successUrl = null,
        ?array $metadata = null,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        $response = $this->http->post(
            "/payments",
            HttpClient::buildBody([
                "amount" => $amount,
                "currency" => $currency,
                "customer_id" => $customerId,
                "description" => $description,
                "success_url" => $successUrl,
                "metadata" => $metadata,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: Payment::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }

    /**
     * Charge a customer's vaulted payment method off-session. Calculates tax, generates an invoice, and sends a receipt. Requires the customer to have a subscription in active, trialing, or past_due state.
     * @param array<string, string>|null $metadata
     * @return ApiResponse<Payment>
     */
    public function charge(
        string $customerId,
        int $amount,
        string $currency,
        string $description,
        ?array $metadata = null,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        $response = $this->http->post(
            "/payments/charge",
            HttpClient::buildBody([
                "customer_id" => $customerId,
                "amount" => $amount,
                "currency" => $currency,
                "description" => $description,
                "metadata" => $metadata,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: Payment::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }

    /**
     * Retrieve a payment by its public ID.
     * @return ApiResponse<Payment>
     */
    public function get(
        string $id,
    ): ApiResponse {
        $response = $this->http->get(
            "/payments/{$id}",
        );

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: Payment::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }

    /**
     * Cancel a pending payment link so it can no longer be paid. Only a link that has not been paid or started processing can be canceled; canceling an already canceled link is a no-op. Charges cannot be canceled.
     * @return ApiResponse<Payment>
     */
    public function cancel(
        string $id,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        $response = $this->http->post(
            "/payments/{$id}/cancel",
            idempotencyKey: $idempotencyKey,
        );

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: Payment::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }
}
