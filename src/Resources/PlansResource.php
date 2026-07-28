<?php

declare(strict_types=1);

namespace Commet\Resources;

use Commet\HttpClient;
use Commet\Models\AddPlanFeatureParamsOverage;
use Commet\Models\AddPlanPriceParamsMarketPricesItem;
use Commet\Models\DeletedObject;
use Commet\Models\DeletedPlanRegionalPricing;
use Commet\Models\Plan;
use Commet\Models\PlanFeature;
use Commet\Models\PlanPrice;
use Commet\Models\PlanRegionalPricing;
use Commet\Models\PlanRegionalPricingResult;
use Commet\Models\PlansListResult;
use Commet\Models\RemovedPlanFeature;
use Commet\Models\SetPlanRegionalPricingParamsFeaturesItem;
use Commet\Models\SetPlanRegionalPricingParamsPricesItem;
use Commet\Models\UpdatePlanFeatureParamsOverage;
use Commet\Models\UpdatePlanPriceParamsMarketPricesItem;
use Commet\Models\UpsertRegionalPricesParamsOverridesItem;

class PlansResource
{
    public function __construct(
        private readonly HttpClient $http,
    ) {}

    /**
     * Update limits, overage, or enabled status of a feature on a plan.
     * @return PlanFeature
     */
    public function updateFeature(
        string $id,
        string $featureId,
        ?bool $enabled = null,
        ?int $includedAmount = null,
        ?bool $unlimited = null,
        ?UpdatePlanFeatureParamsOverage $overage = null,
        ?int $creditsPerUnit = null,
        ?string $idempotencyKey = null,
    ): PlanFeature {
        $response = $this->http->patch(
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

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid PlanFeature response payload");
        }

        return PlanFeature::fromArray($response->data);
    }

    /**
     * Detach a feature from a plan.
     * @return RemovedPlanFeature
     */
    public function removeFeature(
        string $id,
        string $featureId,
    ): RemovedPlanFeature {
        $response = $this->http->delete(
            "/plans/{$id}/features/{$featureId}",
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid RemovedPlanFeature response payload");
        }

        return RemovedPlanFeature::fromArray($response->data);
    }

    /**
     * Attach a feature to a plan with limits, overage, and credits configuration.
     * @return PlanFeature
     */
    public function addFeature(
        string $id,
        string $featureId,
        ?bool $enabled = null,
        ?int $includedAmount = null,
        ?bool $unlimited = null,
        ?AddPlanFeatureParamsOverage $overage = null,
        ?int $creditsPerUnit = null,
        ?string $pricingMode = null,
        ?int $margin = null,
        ?string $idempotencyKey = null,
    ): PlanFeature {
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

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid PlanFeature response payload");
        }

        return PlanFeature::fromArray($response->data);
    }

    /**
     * Set a specific price as the default and return the updated plan price.
     * @return PlanPrice
     */
    public function setDefaultPrice(
        string $id,
        string $priceId,
        ?string $idempotencyKey = null,
    ): PlanPrice {
        $response = $this->http->put(
            "/plans/{$id}/prices/{$priceId}/default",
            idempotencyKey: $idempotencyKey,
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid PlanPrice response payload");
        }

        return PlanPrice::fromArray($response->data);
    }

    /**
     * Create or update regional currency price overrides for a plan price.
     * @param UpsertRegionalPricesParamsOverridesItem[] $overrides
     * @return PlanRegionalPricing
     */
    public function setRegionalPrices(
        string $id,
        string $priceId,
        array $overrides,
        ?string $idempotencyKey = null,
    ): PlanRegionalPricing {
        $response = $this->http->put(
            "/plans/{$id}/prices/{$priceId}/regional",
            HttpClient::buildBody([
                "overrides" => $overrides,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid PlanRegionalPricing response payload");
        }

        return PlanRegionalPricing::fromArray($response->data);
    }

    /**
     * Remove all regional currency overrides for a plan price. The request is rejected while billable subscriptions depend on an override.
     * @return DeletedPlanRegionalPricing
     */
    public function deleteRegionalPrices(
        string $id,
        string $priceId,
    ): DeletedPlanRegionalPricing {
        $response = $this->http->delete(
            "/plans/{$id}/prices/{$priceId}/regional",
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid DeletedPlanRegionalPricing response payload");
        }

        return DeletedPlanRegionalPricing::fromArray($response->data);
    }

    /**
     * Update a base price or market price variant. Removing a base market override is rejected while a variant depends on it. Offer terms are managed through Offers.
     * @param array<string, mixed>|null $metadata
     * @param UpdatePlanPriceParamsMarketPricesItem[]|null $marketPrices
     * @return PlanPrice
     */
    public function updatePrice(
        string $id,
        string $priceId,
        ?int $price = null,
        ?bool $isDefault = null,
        ?int $trialDays = null,
        ?int $includedBalance = null,
        ?int $includedCredits = null,
        ?array $metadata = null,
        ?array $marketPrices = null,
        ?string $idempotencyKey = null,
    ): PlanPrice {
        $response = $this->http->patch(
            "/plans/{$id}/prices/{$priceId}",
            HttpClient::buildBody([
                "price" => $price,
                "is_default" => $isDefault,
                "trial_days" => $trialDays,
                "included_balance" => $includedBalance,
                "included_credits" => $includedCredits,
                "metadata" => $metadata,
                "market_prices" => $marketPrices,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid PlanPrice response payload");
        }

        return PlanPrice::fromArray($response->data);
    }

    /**
     * Archive a price for new subscriptions. Existing subscriptions that selected it continue using its current catalog value.
     * @return DeletedObject
     */
    public function deletePrice(
        string $id,
        string $priceId,
    ): DeletedObject {
        $response = $this->http->delete(
            "/plans/{$id}/prices/{$priceId}",
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid DeletedObject response payload");
        }

        return DeletedObject::fromArray($response->data);
    }

    /**
     * Add a base price or a selectable market price variant. Variants inherit their base price outside the markets they override. Configure introductory and promotional benefits through Offers.
     * @param array<string, mixed>|null $metadata
     * @param AddPlanPriceParamsMarketPricesItem[]|null $marketPrices
     * @return PlanPrice
     */
    public function addPrice(
        string $id,
        string $billingInterval,
        ?array $metadata = null,
        ?int $price = null,
        ?int $trialDays = null,
        ?bool $isDefault = null,
        ?int $includedBalance = null,
        ?int $includedCredits = null,
        ?array $marketPrices = null,
        ?string $inheritsFromPriceId = null,
        ?string $idempotencyKey = null,
    ): PlanPrice {
        $response = $this->http->post(
            "/plans/{$id}/prices",
            HttpClient::buildBody([
                "billing_interval" => $billingInterval,
                "metadata" => $metadata,
                "price" => $price,
                "trial_days" => $trialDays,
                "is_default" => $isDefault,
                "included_balance" => $includedBalance,
                "included_credits" => $includedCredits,
                "market_prices" => $marketPrices,
                "inherits_from_price_id" => $inheritsFromPriceId,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid PlanPrice response payload");
        }

        return PlanPrice::fromArray($response->data);
    }

    /**
     * Configure regional prices and feature overage values for one currency. Currency-specific offer terms are managed through Offers.
     * @param SetPlanRegionalPricingParamsPricesItem[]|null $prices
     * @param SetPlanRegionalPricingParamsFeaturesItem[]|null $features
     * @return PlanRegionalPricingResult
     */
    public function setRegionalPricing(
        string $id,
        string $currency,
        float $exchangeRate,
        ?array $prices = null,
        ?array $features = null,
        ?string $idempotencyKey = null,
    ): PlanRegionalPricingResult {
        $response = $this->http->put(
            "/plans/{$id}/regional",
            HttpClient::buildBody([
                "currency" => $currency,
                "exchange_rate" => $exchangeRate,
                "prices" => $prices,
                "features" => $features,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid PlanRegionalPricingResult response payload");
        }

        return PlanRegionalPricingResult::fromArray($response->data);
    }

    /**
     * Get a plan with public price IDs and their automatic introductory offer IDs.
     * @return Plan
     */
    public function get(
        string $id,
    ): Plan {
        $response = $this->http->get(
            "/plans/{$id}",
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid Plan response payload");
        }

        return Plan::fromArray($response->data);
    }

    /**
     * Update a plan's name, description, visibility, or metadata.
     * @param array<string, mixed>|null $metadata
     * @return Plan
     */
    public function update(
        string $id,
        ?string $name = null,
        ?string $description = null,
        ?array $metadata = null,
        ?bool $isPublic = null,
        ?string $idempotencyKey = null,
    ): Plan {
        $response = $this->http->patch(
            "/plans/{$id}",
            HttpClient::buildBody([
                "name" => $name,
                "description" => $description,
                "metadata" => $metadata,
                "is_public" => $isPublic,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid Plan response payload");
        }

        return Plan::fromArray($response->data);
    }

    /**
     * Soft-delete a plan.
     * @return DeletedObject
     */
    public function delete(
        string $id,
    ): DeletedObject {
        $response = $this->http->delete(
            "/plans/{$id}",
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid DeletedObject response payload");
        }

        return DeletedObject::fromArray($response->data);
    }

    /**
     * Set a plan's public visibility and return the updated plan.
     * @return Plan
     */
    public function setVisibility(
        string $id,
        bool $isPublic,
        ?string $idempotencyKey = null,
    ): Plan {
        $response = $this->http->put(
            "/plans/{$id}/visibility",
            HttpClient::buildBody([
                "is_public" => $isPublic,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid Plan response payload");
        }

        return Plan::fromArray($response->data);
    }

    /**
     * List plans with public price IDs and their automatic introductory offer IDs.
     * @return PlansListResult
     */
    public function list(
        ?bool $includePrivate = null,
    ): PlansListResult {
        $response = $this->http->get(
            "/plans",
            HttpClient::buildBody([
                "include_private" => $includePrivate,
            ]),
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid PlansListResult response payload");
        }

        return PlansListResult::fromArray($response->data);
    }

    /**
     * Create a new plan with optional consumption model, visibility, and plan group assignment.
     * @param array<string, mixed>|null $metadata
     * @return Plan
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
    ): Plan {
        $response = $this->http->post(
            "/plans",
            HttpClient::buildBody([
                "name" => $name,
                "code" => $code,
                "description" => $description,
                "consumption_model" => $consumptionModel,
                "is_public" => $isPublic,
                "is_free" => $isFree,
                "block_on_exhaustion" => $blockOnExhaustion,
                "plan_group_id" => $planGroupId,
                "metadata" => $metadata,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid Plan response payload");
        }

        return Plan::fromArray($response->data);
    }
}
