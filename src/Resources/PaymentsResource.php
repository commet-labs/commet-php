<?php

declare(strict_types=1);

namespace Commet\Resources;

use Commet\HttpClient;
use Commet\Models\Payment;
use Commet\Models\PaymentsListResult;

class PaymentsResource
{
    public function __construct(
        private readonly HttpClient $http,
    ) {}

    /**
     * Cancel a pending payment link so it can no longer be paid. Only a link that has not been paid or started processing can be canceled; canceling an already canceled link is a no-op. Charges cannot be canceled.
     * @return Payment
     */
    public function cancel(
        string $id,
        ?string $idempotencyKey = null,
    ): Payment {
        $response = $this->http->post(
            "/payments/{$id}/cancel",
            idempotencyKey: $idempotencyKey,
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid Payment response payload");
        }

        return Payment::fromArray($response->data);
    }

    /**
     * Retrieve a payment by its public ID.
     * @return Payment
     */
    public function get(
        string $id,
    ): Payment {
        $response = $this->http->get(
            "/payments/{$id}",
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid Payment response payload");
        }

        return Payment::fromArray($response->data);
    }

    /**
     * Charge a customer's vaulted payment method off-session. Calculates tax, generates an invoice, and sends a receipt. Requires the customer to have a subscription in active, trialing, or past_due state.
     * @param array<string, string>|null $metadata
     * @return Payment
     */
    public function charge(
        string $customerId,
        int $amount,
        string $currency,
        string $description,
        ?array $metadata = null,
        ?string $idempotencyKey = null,
    ): Payment {
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

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid Payment response payload");
        }

        return Payment::fromArray($response->data);
    }

    /**
     * List payments with cursor-based pagination. Filter by customer.
     * @return PaymentsListResult
     */
    public function list(
        ?string $cursor = null,
        ?int $limit = null,
        ?string $customerId = null,
    ): PaymentsListResult {
        $response = $this->http->get(
            "/payments",
            HttpClient::buildBody([
                "cursor" => $cursor,
                "limit" => $limit,
                "customer_id" => $customerId,
            ]),
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid PaymentsListResult response payload");
        }

        return PaymentsListResult::fromArray($response->data);
    }

    /**
     * Create a hosted payment link. Returns a url the customer opens to pay with any card. Calculates tax, generates an invoice, and vaults the payment method on confirmation. No subscription or plan required.
     * @param array<string, string>|null $metadata
     * @return Payment
     */
    public function create(
        int $amount,
        string $currency,
        string $description,
        ?string $customerId = null,
        ?string $successUrl = null,
        ?array $metadata = null,
        ?string $idempotencyKey = null,
    ): Payment {
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

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid Payment response payload");
        }

        return Payment::fromArray($response->data);
    }
}
