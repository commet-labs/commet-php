<?php

declare(strict_types=1);

namespace Commet\Resources;

use Commet\HttpClient;
use Commet\Models\PromoCode;
use Commet\Models\PromoCodesListResult;

class PromoCodesResource
{
    public function __construct(
        private readonly HttpClient $http,
    ) {}

    /**
     * Retrieve a promo code by its public ID.
     * @return PromoCode
     */
    public function get(
        string $id,
    ): PromoCode {
        $response = $this->http->get(
            "/promo-codes/{$id}",
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid PromoCode response payload");
        }

        return PromoCode::fromArray($response->data);
    }

    /**
     * Update a promo code's billing interval, redemption limits, expiration, active status, or plan restrictions.
     * @param string[]|null $planIds
     * @return PromoCode
     */
    public function update(
        string $id,
        ?string $billingInterval = null,
        ?int $maxRedemptions = null,
        ?string $expiresAt = null,
        ?bool $active = null,
        ?array $planIds = null,
        ?string $idempotencyKey = null,
    ): PromoCode {
        $response = $this->http->patch(
            "/promo-codes/{$id}",
            HttpClient::buildBody([
                "billing_interval" => $billingInterval,
                "max_redemptions" => $maxRedemptions,
                "expires_at" => $expiresAt,
                "active" => $active,
                "plan_ids" => $planIds,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid PromoCode response payload");
        }

        return PromoCode::fromArray($response->data);
    }

    /**
     * List promo codes with cursor-based pagination.
     * @return PromoCodesListResult
     */
    public function list(
        ?string $cursor = null,
        ?int $limit = null,
    ): PromoCodesListResult {
        $response = $this->http->get(
            "/promo-codes",
            HttpClient::buildBody([
                "cursor" => $cursor,
                "limit" => $limit,
            ]),
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid PromoCodesListResult response payload");
        }

        return PromoCodesListResult::fromArray($response->data);
    }

    /**
     * Create a distribution code for an existing Offer. The referenced Offer owns the benefit and duration; the promo code owns redemption restrictions.
     * @param string[]|null $planIds
     * @return PromoCode
     */
    public function create(
        string $code,
        string $offerId,
        ?string $billingInterval = null,
        ?int $maxRedemptions = null,
        ?string $expiresAt = null,
        ?array $planIds = null,
        ?string $idempotencyKey = null,
    ): PromoCode {
        $response = $this->http->post(
            "/promo-codes",
            HttpClient::buildBody([
                "code" => $code,
                "offer_id" => $offerId,
                "billing_interval" => $billingInterval,
                "max_redemptions" => $maxRedemptions,
                "expires_at" => $expiresAt,
                "plan_ids" => $planIds,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid PromoCode response payload");
        }

        return PromoCode::fromArray($response->data);
    }
}
