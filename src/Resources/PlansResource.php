<?php

declare(strict_types=1);

namespace Commet\Resources;

use Commet\ApiResponse;
use Commet\Enums\BillingInterval;
use Commet\Enums\ConsumptionModel;
use Commet\Enums\DiscountType;
use Commet\HttpClient;
use Commet\Models\DefaultPlanPrice;
use Commet\Models\DeletedObject;
use Commet\Models\DeletedPlanRegionalPricing;
use Commet\Models\Plan;
use Commet\Models\PlanFeature;
use Commet\Models\PlanPrice;
use Commet\Models\PlanRegionalPricing;
use Commet\Models\PlanRegionalPricingResult;
use Commet\Models\PlanVisibility;
use Commet\Models\RemovedPlanFeature;

class PlansResource
{
    public function __construct(
        private readonly HttpClient $http,
    ) {}

    /**
     * List all plans with their prices and features. Optionally include private plans.
     * @return ApiResponse<Plan[]>
     */
    public function list(
        ?string $includePrivate = null,
    ): ApiResponse {
        $response = $this->http->get(
            "/plans",
            HttpClient::buildBody([
                "include_private" => $includePrivate,
            ]),
        );

        if ($response->success && is_array($response->data)) {
            $items = array_map(
                fn(array $item) => Plan::fromArray($item),
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
     * Get detailed plan information by code or ID.
     * @return ApiResponse<Plan>
     */
    public function get(
        string $id,
    ): ApiResponse {
        $response = $this->http->get(
            "/plans/{$id}",
        );

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: Plan::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }

    /**
     * Create a new plan with optional consumption model, visibility, and plan group assignment.
     * @param array<string, mixed>|null $metadata
     * @return ApiResponse<Plan>
     */
    public function create(
        string $name,
        string $code,
        ?string $description = null,
        ?ConsumptionModel $consumptionModel = null,
        ?bool $isPublic = null,
        ?bool $isFree = null,
        ?bool $blockOnExhaustion = null,
        ?string $planGroupId = null,
        ?array $metadata = null,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        $response = $this->http->post(
            "/plans/manage",
            HttpClient::buildBody([
                "name" => $name,
                "code" => $code,
                "description" => $description,
                "consumption_model" => $consumptionModel?->value,
                "is_public" => $isPublic,
                "is_free" => $isFree,
                "block_on_exhaustion" => $blockOnExhaustion,
                "plan_group_id" => $planGroupId,
                "metadata" => $metadata,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: Plan::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }

    /**
     * Update a plan's name, description, visibility, or metadata.
     * @param array<string, mixed>|null $metadata
     * @return ApiResponse<Plan>
     */
    public function update(
        string $id,
        ?string $name = null,
        ?string $description = null,
        ?array $metadata = null,
        ?bool $isPublic = null,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        $response = $this->http->put(
            "/plans/{$id}/manage",
            HttpClient::buildBody([
                "name" => $name,
                "description" => $description,
                "metadata" => $metadata,
                "is_public" => $isPublic,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: Plan::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }

    /**
     * Soft-delete a plan.
     * @return ApiResponse<DeletedObject>
     */
    public function delete(
        string $id,
    ): ApiResponse {
        $response = $this->http->delete(
            "/plans/{$id}/manage",
        );

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: DeletedObject::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }

    /**
     * Toggle a plan between public and private.
     * @return ApiResponse<PlanVisibility>
     */
    public function setVisibility(
        string $id,
        bool $isPublic,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        $response = $this->http->put(
            "/plans/{$id}/visibility",
            HttpClient::buildBody([
                "is_public" => $isPublic,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: PlanVisibility::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }

    /**
     * Attach a feature to a plan with limits, overage, and credits configuration.
     * @param array<string, mixed>|null $overage
     * @return ApiResponse<PlanFeature>
     */
    public function addFeature(
        string $id,
        string $featureId,
        ?bool $enabled = null,
        ?int $includedAmount = null,
        ?bool $unlimited = null,
        ?array $overage = null,
        ?int $creditsPerUnit = null,
        ?string $pricingMode = null,
        ?int $margin = null,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        $response = $this->http->post(
            "/plans/{$id}/features",
            HttpClient::buildBody([
                "feature_id" => $featureId,
                "enabled" => $enabled,
                "included_amount" => $includedAmount,
                "unlimited" => $unlimited,
                "overage" => $overage,
                "credits_per_unit" => $creditsPerUnit,
                "pricing_mode" => $pricingMode,
                "margin" => $margin,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: PlanFeature::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }

    /**
     * Update limits, overage, or enabled status of a feature on a plan.
     * @param array<string, mixed>|null $overage
     * @return ApiResponse<PlanFeature>
     */
    public function updateFeature(
        string $id,
        string $featureId,
        ?bool $enabled = null,
        ?int $includedAmount = null,
        ?bool $unlimited = null,
        ?array $overage = null,
        ?int $creditsPerUnit = null,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        $response = $this->http->put(
            "/plans/{$id}/features/{$featureId}",
            HttpClient::buildBody([
                "enabled" => $enabled,
                "included_amount" => $includedAmount,
                "unlimited" => $unlimited,
                "overage" => $overage,
                "credits_per_unit" => $creditsPerUnit,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: PlanFeature::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }

    /**
     * Detach a feature from a plan.
     * @return ApiResponse<RemovedPlanFeature>
     */
    public function removeFeature(
        string $id,
        string $featureId,
    ): ApiResponse {
        $response = $this->http->delete(
            "/plans/{$id}/features/{$featureId}",
        );

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: RemovedPlanFeature::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }

    /**
     * Add a billing interval price to a plan with optional trial days and included balance/credits.
     * @param array<string, mixed>|null $introOffer
     * @return ApiResponse<PlanPrice>
     */
    public function addPrice(
        string $id,
        BillingInterval $billingInterval,
        int $price,
        ?int $trialDays = null,
        ?bool $isDefault = null,
        ?int $includedBalance = null,
        ?int $includedCredits = null,
        ?array $introOffer = null,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        $response = $this->http->post(
            "/plans/{$id}/prices",
            HttpClient::buildBody([
                "billing_interval" => $billingInterval->value,
                "price" => $price,
                "trial_days" => $trialDays,
                "is_default" => $isDefault,
                "included_balance" => $includedBalance,
                "included_credits" => $includedCredits,
                "intro_offer" => $introOffer,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: PlanPrice::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }

    /**
     * Update an existing price on a plan.
     * @param array<string, mixed>|null $introOffer
     * @return ApiResponse<PlanPrice>
     */
    public function updatePrice(
        string $id,
        string $priceId,
        ?int $price = null,
        ?bool $isDefault = null,
        ?int $trialDays = null,
        ?int $includedBalance = null,
        ?int $includedCredits = null,
        ?array $introOffer = null,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        $response = $this->http->put(
            "/plans/{$id}/prices/{$priceId}",
            HttpClient::buildBody([
                "price" => $price,
                "is_default" => $isDefault,
                "trial_days" => $trialDays,
                "included_balance" => $includedBalance,
                "included_credits" => $includedCredits,
                "intro_offer" => $introOffer,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: PlanPrice::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }

    /**
     * Remove a price from a plan.
     * @return ApiResponse<DeletedObject>
     */
    public function deletePrice(
        string $id,
        string $priceId,
    ): ApiResponse {
        $response = $this->http->delete(
            "/plans/{$id}/prices/{$priceId}",
        );

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: DeletedObject::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }

    /**
     * Set a specific price as the default for its plan. Unsets previous default.
     * @return ApiResponse<DefaultPlanPrice>
     */
    public function setDefaultPrice(
        string $id,
        string $priceId,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        $response = $this->http->put(
            "/plans/{$id}/prices/{$priceId}/default",
            idempotencyKey: $idempotencyKey,
        );

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: DefaultPlanPrice::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }

    /**
     * Create or update regional currency price overrides for a plan price.
     * @param list<array<string, mixed>> $overrides
     * @return ApiResponse<PlanRegionalPricing>
     */
    public function setRegionalPrices(
        string $id,
        string $priceId,
        array $overrides,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        $response = $this->http->put(
            "/plans/{$id}/prices/{$priceId}/regional",
            HttpClient::buildBody([
                "overrides" => $overrides,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: PlanRegionalPricing::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }

    /**
     * Configure a plan's regional pricing for one currency. USD configures the United States variant; exchangeRate acts as its price multiplier. Sending only currency and exchangeRate derives every regional value (base price, included balance, feature overage, intro offer) from the default USD value. Optional per-price and per-feature overrides are stored as manual values.
     * @param list<array<string, mixed>>|null $prices
     * @param list<array<string, mixed>>|null $features
     * @param list<array<string, mixed>>|null $introOffers
     * @return ApiResponse<PlanRegionalPricingResult>
     */
    public function setRegionalPricing(
        string $id,
        string $currency,
        float $exchangeRate,
        ?array $prices = null,
        ?array $features = null,
        ?array $introOffers = null,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        $response = $this->http->put(
            "/plans/{$id}/regional",
            HttpClient::buildBody([
                "currency" => $currency,
                "exchange_rate" => $exchangeRate,
                "prices" => $prices,
                "features" => $features,
                "intro_offers" => $introOffers,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: PlanRegionalPricingResult::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }

    /**
     * Remove all regional currency overrides for a plan price.
     * @return ApiResponse<DeletedPlanRegionalPricing>
     */
    public function deleteRegionalPrices(
        string $id,
        string $priceId,
    ): ApiResponse {
        $response = $this->http->delete(
            "/plans/{$id}/prices/{$priceId}/regional",
        );

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: DeletedPlanRegionalPricing::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }
}
