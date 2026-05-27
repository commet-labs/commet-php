<?php

declare(strict_types=1);

namespace Commet\Resources;

use Commet\ApiResponse;
use Commet\HttpClient;
use Commet\Models\Plan;
use Commet\Models\PlanFeatureManage;
use Commet\Models\PlanManage;
use Commet\Models\PlanPriceManage;

class PlansResource
{
    public function __construct(
        private readonly HttpClient $http,
    ) {}

    /**
     * @return ApiResponse<Plan[]>
     */
    public function list(
        ?bool $includePrivate = null,
        ?int $limit = null,
        ?string $cursor = null,
    ): ApiResponse {
        $response = $this->http->get(
            '/plans',
            HttpClient::buildBody([
                'include_private' => $includePrivate,
                'limit' => $limit,
                'cursor' => $cursor,
            ]),
        );

        if ($response->success && is_array($response->data)) {
            $plans = array_map(
                fn(array $item) => Plan::fromArray($item),
                $response->data,
            );

            return new ApiResponse(
                success: true,
                data: $plans,
                code: $response->code,
                message: $response->message,
                hasMore: $response->hasMore,
                nextCursor: $response->nextCursor,
            );
        }

        return $response;
    }

    /**
     * @return ApiResponse<Plan>
     */
    public function get(string $planId): ApiResponse
    {
        $response = $this->http->get("/plans/{$planId}");

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
     * @param array<string, mixed>|null $metadata
     * @return ApiResponse<PlanManage>
     */
    public function create(
        string $name,
        string $code,
        ?string $description = null,
        ?string $consumptionModel = null,
        ?bool $isPublic = null,
        ?bool $isFree = null,
        ?bool $blockOnExhaustion = null,
        ?string $planGroupId = null,
        ?array $metadata = null,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        $response = $this->http->post(
            '/plans/manage',
            HttpClient::buildBody([
                'name' => $name,
                'code' => $code,
                'description' => $description,
                'consumption_model' => $consumptionModel,
                'is_public' => $isPublic,
                'is_free' => $isFree,
                'block_on_exhaustion' => $blockOnExhaustion,
                'plan_group_id' => $planGroupId,
                'metadata' => $metadata,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: PlanManage::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }

    /**
     * @param array<string, mixed>|null $metadata
     * @return ApiResponse<PlanManage>
     */
    public function update(
        string $planId,
        ?string $name = null,
        ?string $description = null,
        ?array $metadata = null,
        ?bool $isPublic = null,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        $response = $this->http->put(
            "/plans/{$planId}/manage",
            HttpClient::buildBody([
                'name' => $name,
                'description' => $description,
                'metadata' => $metadata,
                'is_public' => $isPublic,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: PlanManage::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }

    /**
     * @return ApiResponse<array{id: string, deleted: true}>
     */
    public function delete(
        string $planId,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        return $this->http->delete("/plans/{$planId}/manage", idempotencyKey: $idempotencyKey);
    }

    /**
     * @return ApiResponse<PlanManage>
     */
    public function setVisibility(
        string $planId,
        bool $isPublic,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        $response = $this->http->put(
            "/plans/{$planId}/visibility",
            ['is_public' => $isPublic],
            idempotencyKey: $idempotencyKey,
        );

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: PlanManage::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }

    /**
     * @return ApiResponse<PlanFeatureManage>
     */
    public function addFeature(
        string $planId,
        string $featureId,
        ?bool $enabled = null,
        ?int $includedAmount = null,
        ?bool $unlimited = null,
        ?bool $overageEnabled = null,
        ?int $creditsPerUnit = null,
        ?string $pricingMode = null,
        ?int $overageUnitPrice = null,
        ?int $margin = null,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        $response = $this->http->post(
            "/plans/{$planId}/features",
            HttpClient::buildBody([
                'feature_id' => $featureId,
                'enabled' => $enabled,
                'included_amount' => $includedAmount,
                'unlimited' => $unlimited,
                'overage_enabled' => $overageEnabled,
                'credits_per_unit' => $creditsPerUnit,
                'pricing_mode' => $pricingMode,
                'overage_unit_price' => $overageUnitPrice,
                'margin' => $margin,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: PlanFeatureManage::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }

    /**
     * @return ApiResponse<PlanFeatureManage>
     */
    public function updateFeature(
        string $planId,
        string $featureId,
        ?bool $enabled = null,
        ?int $includedAmount = null,
        ?bool $unlimited = null,
        ?bool $overageEnabled = null,
        ?int $creditsPerUnit = null,
        ?string $pricingMode = null,
        ?int $overageUnitPrice = null,
        ?int $margin = null,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        $response = $this->http->put(
            "/plans/{$planId}/features/{$featureId}",
            HttpClient::buildBody([
                'enabled' => $enabled,
                'included_amount' => $includedAmount,
                'unlimited' => $unlimited,
                'overage_enabled' => $overageEnabled,
                'credits_per_unit' => $creditsPerUnit,
                'pricing_mode' => $pricingMode,
                'overage_unit_price' => $overageUnitPrice,
                'margin' => $margin,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: PlanFeatureManage::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }

    /**
     * @return ApiResponse<array{id: string, removed: true}>
     */
    public function removeFeature(
        string $planId,
        string $featureId,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        return $this->http->delete(
            "/plans/{$planId}/features/{$featureId}",
            idempotencyKey: $idempotencyKey,
        );
    }

    /**
     * @return ApiResponse<PlanPriceManage>
     */
    public function addPrice(
        string $planId,
        string $billingInterval,
        int $price,
        ?int $trialDays = null,
        ?bool $isDefault = null,
        ?int $includedBalance = null,
        ?int $includedCredits = null,
        ?bool $introOfferEnabled = null,
        ?string $introOfferDiscountType = null,
        ?int $introOfferDiscountValue = null,
        ?int $introOfferDurationCycles = null,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        $response = $this->http->post(
            "/plans/{$planId}/prices",
            HttpClient::buildBody([
                'billing_interval' => $billingInterval,
                'price' => $price,
                'trial_days' => $trialDays,
                'is_default' => $isDefault,
                'included_balance' => $includedBalance,
                'included_credits' => $includedCredits,
                'intro_offer_enabled' => $introOfferEnabled,
                'intro_offer_discount_type' => $introOfferDiscountType,
                'intro_offer_discount_value' => $introOfferDiscountValue,
                'intro_offer_duration_cycles' => $introOfferDurationCycles,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: PlanPriceManage::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }

    /**
     * @return ApiResponse<PlanPriceManage>
     */
    public function updatePrice(
        string $planId,
        string $priceId,
        ?int $price = null,
        ?bool $isDefault = null,
        ?int $trialDays = null,
        ?int $includedBalance = null,
        ?int $includedCredits = null,
        ?bool $introOfferEnabled = null,
        ?string $introOfferDiscountType = null,
        ?int $introOfferDiscountValue = null,
        ?int $introOfferDurationCycles = null,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        $response = $this->http->put(
            "/plans/{$planId}/prices/{$priceId}",
            HttpClient::buildBody([
                'price' => $price,
                'is_default' => $isDefault,
                'trial_days' => $trialDays,
                'included_balance' => $includedBalance,
                'included_credits' => $includedCredits,
                'intro_offer_enabled' => $introOfferEnabled,
                'intro_offer_discount_type' => $introOfferDiscountType,
                'intro_offer_discount_value' => $introOfferDiscountValue,
                'intro_offer_duration_cycles' => $introOfferDurationCycles,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: PlanPriceManage::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }

    /**
     * @return ApiResponse<array{id: string, deleted: true}>
     */
    public function deletePrice(
        string $planId,
        string $priceId,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        return $this->http->delete(
            "/plans/{$planId}/prices/{$priceId}",
            idempotencyKey: $idempotencyKey,
        );
    }

    /**
     * @return ApiResponse<PlanPriceManage>
     */
    public function setDefaultPrice(
        string $planId,
        string $priceId,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        $response = $this->http->put(
            "/plans/{$planId}/prices/{$priceId}/default",
            [],
            idempotencyKey: $idempotencyKey,
        );

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: PlanPriceManage::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }

    /**
     * @param array<int, array{currency: string, price: int}> $overrides
     * @return ApiResponse<array{price_id: string, overrides: array<int, array{currency: string, price: int}>}>
     */
    public function setRegionalPrices(
        string $planId,
        string $priceId,
        array $overrides,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        return $this->http->put(
            "/plans/{$planId}/prices/{$priceId}/regional",
            ['overrides' => $overrides],
            idempotencyKey: $idempotencyKey,
        );
    }

    /**
     * @return ApiResponse<array{id: string, deleted: true}>
     */
    public function deleteRegionalPrices(
        string $planId,
        string $priceId,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        return $this->http->delete(
            "/plans/{$planId}/prices/{$priceId}/regional",
            idempotencyKey: $idempotencyKey,
        );
    }
}
