<?php

declare(strict_types=1);

namespace Commet\Resources;

use Commet\ApiResponse;
use Commet\Enums\TransactionStatus;
use Commet\HttpClient;
use Commet\Models\Transaction;
use Commet\Models\TransactionRefundResult;
use Commet\Models\TransactionRetryResult;

class TransactionsResource
{
    public function __construct(
        private readonly HttpClient $http,
    ) {}

    /**
     * @return ApiResponse<Transaction[]>
     */
    public function list(
        ?TransactionStatus $status = null,
        ?string $customerEmail = null,
        ?int $limit = null,
        ?string $cursor = null,
    ): ApiResponse {
        $response = $this->http->get(
            '/transactions',
            HttpClient::buildBody([
                'status' => $status?->value,
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
     * Full refund only.
     *
     * @return ApiResponse<TransactionRefundResult>
     */
    public function refund(
        string $id,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        $response = $this->http->post("/transactions/{$id}/refund", [], idempotencyKey: $idempotencyKey);

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: TransactionRefundResult::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }

    /**
     * Creates a new invoice and initiates a new payment attempt.
     *
     * The returned `status` is the synthetic literal `'processing'`, which is not
     * a member of {@see TransactionStatus}, so it stays typed as a plain string.
     *
     * @return ApiResponse<TransactionRetryResult>
     */
    public function retry(
        string $id,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        $response = $this->http->post("/transactions/{$id}/retry", [], idempotencyKey: $idempotencyKey);

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: TransactionRetryResult::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }
}
