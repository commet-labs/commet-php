<?php

declare(strict_types=1);

namespace Commet\Resources;

use Commet\ApiResponse;
use Commet\HttpClient;
use Commet\Models\Transaction;

class TransactionsResource
{
    public function __construct(
        private readonly HttpClient $http,
    ) {}

    /**
     * @return ApiResponse<Transaction[]>
     */
    public function list(
        ?string $status = null,
        ?string $customerEmail = null,
        ?int $limit = null,
        ?string $cursor = null,
    ): ApiResponse {
        $response = $this->http->get(
            '/transactions',
            HttpClient::buildBody([
                'status' => $status,
                'customer_email' => $customerEmail,
                'limit' => $limit,
                'cursor' => $cursor,
            ]),
        );

        if ($response->success && is_array($response->data)) {
            $transactions = array_map(
                fn(array $item) => Transaction::fromArray($item),
                $response->data,
            );

            return new ApiResponse(
                success: true,
                data: $transactions,
                code: $response->code,
                message: $response->message,
                hasMore: $response->hasMore,
                nextCursor: $response->nextCursor,
            );
        }

        return $response;
    }

    /**
     * @return ApiResponse<Transaction>
     */
    public function get(string $id): ApiResponse
    {
        $response = $this->http->get("/transactions/{$id}");

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: Transaction::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }

    /**
     * @return ApiResponse<array{id: string, status: string}>
     */
    public function refund(
        string $id,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        return $this->http->post("/transactions/{$id}/refund", [], idempotencyKey: $idempotencyKey);
    }

    /**
     * @return ApiResponse<array{id: string, status: string, retry_invoice_number: string}>
     */
    public function retry(
        string $id,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        return $this->http->post("/transactions/{$id}/retry", [], idempotencyKey: $idempotencyKey);
    }
}
