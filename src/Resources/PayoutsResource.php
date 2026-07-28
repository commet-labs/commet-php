<?php

declare(strict_types=1);

namespace Commet\Resources;

use Commet\HttpClient;
use Commet\Models\CompletePayoutVerificationParamsBank;
use Commet\Models\CompletePayoutVerificationParamsCompany;
use Commet\Models\CompletePayoutVerificationParamsIndividual;
use Commet\Models\Payout;
use Commet\Models\PayoutBankAccount;
use Commet\Models\PayoutVerification;

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
     * Provision the organization's payout account in a single call with the full KYC + bank payload. Uploads the identity document, persists the destination bank, and creates the connected account through the org's payout provider. The account starts `pending_verification` and flips to `verified` via the provider's webhook. Idempotent: returns the existing account if the org already has one.
     * @return PayoutVerification
     */
    public function completeVerification(
        string $email,
        string $businessUrl,
        string $documentUrl,
        CompletePayoutVerificationParamsBank $bank,
        string $businessType,
        ?CompletePayoutVerificationParamsIndividual $individual = null,
        ?CompletePayoutVerificationParamsCompany $company = null,
        ?string $idempotencyKey = null,
    ): PayoutVerification {
        $response = $this->http->post(
            "/payouts/verification",
            HttpClient::buildBody([
                "email" => $email,
                "business_url" => $businessUrl,
                "document_url" => $documentUrl,
                "bank" => $bank,
                "business_type" => $businessType,
                "individual" => $individual,
                "company" => $company,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid PayoutVerification response payload");
        }

        return PayoutVerification::fromArray($response->data);
    }
}
