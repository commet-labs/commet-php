<?php

declare(strict_types=1);

namespace Commet\Resources;

use Commet\HttpClient;
use Commet\Models\Payout;
use Commet\Models\PayoutBankAccount;

class PayoutsResource
{
    public function __construct(
        private readonly HttpClient $http,
    ) {}

    /**
     * Add an additional destination bank account to the organization's existing payout account. Country and currency are resolved from the organization. The full account number is never returned — only `last4`.
     * @return PayoutBankAccount
     */
    public function addBankAccount(
        string $accountNumber,
        string $accountHolderName,
        ?string $routingNumber = null,
        ?string $accountType = null,
        ?bool $setDefault = null,
        ?string $idempotencyKey = null,
    ): PayoutBankAccount {
        $response = $this->http->post(
            "/payouts/bank-accounts",
            HttpClient::buildBody([
                "account_number" => $accountNumber,
                "account_holder_name" => $accountHolderName,
                "routing_number" => $routingNumber,
                "account_type" => $accountType,
                "set_default" => $setDefault,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid PayoutBankAccount response payload");
        }

        return PayoutBankAccount::fromArray($response->data);
    }

    /**
     * Withdraw available balance to the organization's verified payout account. `amount` is in cents (USD, minimum 1000 = $10). The payout is created in `pending` and settles to `paid` asynchronously as provider webhooks arrive.
     * @return Payout
     */
    public function request(
        int $amount,
        ?string $description = null,
        ?string $idempotencyKey = null,
    ): Payout {
        $response = $this->http->post(
            "/payouts",
            HttpClient::buildBody([
                "amount" => $amount,
                "description" => $description,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid Payout response payload");
        }

        return Payout::fromArray($response->data);
    }

    /**
     * Deprecated. Complete business and identity verification in the Commet dashboard. This endpoint no longer accepts or processes KYC data.
     * @return null
     * @deprecated
     */
    public function completeVerification(
        ?string $idempotencyKey = null,
    ): mixed {
        return $this->http->post(
            "/payouts/verification",
            idempotencyKey: $idempotencyKey,
        )->data;
    }
}
