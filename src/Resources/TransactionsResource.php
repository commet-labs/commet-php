<?php

declare(strict_types=1);

namespace Commet\Resources;

use Commet\Enums\TransactionStatus;
use Commet\HttpClient;
use Commet\Models\Refund;
use Commet\Models\Transaction;
use Commet\Models\TransactionRetry;
use Commet\Models\TransactionsListResult;

class TransactionsResource
{
    public function __construct(
        private readonly HttpClient $http,
    ) {}

    /**
     * Issue a full refund and return the provider-neutral refund resource with its actual status.
     * @return Refund
     */
    public function refund(
        string $id,
        ?string $idempotencyKey = null,
    ): Refund {
        $response = $this->http->post(
            "/transactions/{$id}/refund",
            idempotencyKey: $idempotencyKey,
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid Refund response payload");
        }

        return Refund::fromArray($response->data);
    }

    /**
     * Retry a failed subscription renewal and return an honest retry result. The original failed transaction remains immutable.
     * @return TransactionRetry
     */
    public function retry(
        string $id,
        ?string $idempotencyKey = null,
    ): TransactionRetry {
        $response = $this->http->post(
            "/transactions/{$id}/retry",
            idempotencyKey: $idempotencyKey,
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid TransactionRetry response payload");
        }

        return TransactionRetry::fromArray($response->data);
    }

    /**
     * Retrieve a single payment transaction by its public ID, including provider details.
     * @return Transaction
     */
    public function get(
        string $id,
    ): Transaction {
        $response = $this->http->get(
            "/transactions/{$id}",
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid Transaction response payload");
        }

        return Transaction::fromArray($response->data);
    }

    /**
     * List payment transactions with cursor-based pagination. Filter by status or customer email.
     * @return TransactionsListResult
     */
    public function list(
        ?string $cursor = null,
        ?int $limit = null,
        ?TransactionStatus $status = null,
        ?string $customerEmail = null,
    ): TransactionsListResult {
        $response = $this->http->get(
            "/transactions",
            HttpClient::buildBody([
                "cursor" => $cursor,
                "limit" => $limit,
                "status" => $status?->value,
                "customer_email" => $customerEmail,
            ]),
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid TransactionsListResult response payload");
        }

        return TransactionsListResult::fromArray($response->data);
    }
}
