<?php

declare(strict_types=1);

namespace Commet\Resources;

use Commet\HttpClient;
use Commet\Models\Invoice;
use Commet\Models\InvoiceDownload;
use Commet\Models\InvoicesListResult;
use Commet\Models\SentInvoice;

class InvoicesResource
{
    public function __construct(
        private readonly HttpClient $http,
    ) {}

    /**
     * Generate a signed URL to download the invoice as a PDF. The URL expires after 7 days.
     * @return InvoiceDownload
     */
    public function getDownloadUrl(
        string $id,
        ?string $idempotencyKey = null,
    ): InvoiceDownload {
        $response = $this->http->post(
            "/invoices/{$id}/download-links",
            idempotencyKey: $idempotencyKey,
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid InvoiceDownload response payload");
        }

        return InvoiceDownload::fromArray($response->data);
    }

    /**
     * Retrieve a single invoice by its public ID, including line items.
     * @return Invoice
     */
    public function get(
        string $id,
    ): Invoice {
        $response = $this->http->get(
            "/invoices/{$id}",
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid Invoice response payload");
        }

        return Invoice::fromArray($response->data);
    }

    /**
     * Send the invoice to the customer via email.
     * @return SentInvoice
     */
    public function send(
        string $id,
        ?string $idempotencyKey = null,
    ): SentInvoice {
        $response = $this->http->post(
            "/invoices/{$id}/send",
            idempotencyKey: $idempotencyKey,
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid SentInvoice response payload");
        }

        return SentInvoice::fromArray($response->data);
    }

    /**
     * Mark an outstanding invoice as "paid" or "void" and return the updated invoice. Cannot change the status of already paid or voided invoices.
     * @return Invoice
     */
    public function updateStatus(
        string $id,
        string $status,
        ?string $idempotencyKey = null,
    ): Invoice {
        $response = $this->http->patch(
            "/invoices/{$id}/status",
            HttpClient::buildBody([
                "status" => $status,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid Invoice response payload");
        }

        return Invoice::fromArray($response->data);
    }

    /**
     * List invoices with cursor-based pagination. Filter by customer, status, or subscription.
     * @return InvoicesListResult
     */
    public function list(
        ?string $cursor = null,
        ?int $limit = null,
        ?string $customerId = null,
        ?string $status = null,
        ?string $subscriptionId = null,
    ): InvoicesListResult {
        $response = $this->http->get(
            "/invoices",
            HttpClient::buildBody([
                "cursor" => $cursor,
                "limit" => $limit,
                "customer_id" => $customerId,
                "status" => $status,
                "subscription_id" => $subscriptionId,
            ]),
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid InvoicesListResult response payload");
        }

        return InvoicesListResult::fromArray($response->data);
    }

    /**
     * Create a one-off adjustment invoice and return the created invoice. Use a negative amount for a credit.
     * @param array<string, mixed>|null $metadata
     * @return Invoice
     */
    public function createAdjustment(
        string $customerId,
        int $amount,
        string $description,
        ?array $metadata = null,
        ?string $idempotencyKey = null,
    ): Invoice {
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

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid Invoice response payload");
        }

        return Invoice::fromArray($response->data);
    }
}
