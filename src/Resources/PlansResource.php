<?php

declare(strict_types=1);

namespace Commet\Resources;

use Commet\HttpClient;
use Commet\Models\AddPlanFeatureParamsOverage;
use Commet\Models\AddPlanPriceParamsMarketPricesItem;
use Commet\Models\ArchivePlanExperimentParamsChangesItem;
use Commet\Models\CreatePlanExperimentParamsCurrenciesItem;
use Commet\Models\CreatePlanExperimentParamsPricesItem;
use Commet\Models\CreatePlanExperimentVersionParamsCurrenciesItem;
use Commet\Models\CreatePlanExperimentVersionParamsPricesItem;
use Commet\Models\CreatePlanMoveParamsChangesItem;
use Commet\Models\CreatePlanParamsPlanBalanceLimit;
use Commet\Models\CreatePlanParamsPlanCreditLimit;
use Commet\Models\CreatePlanParamsUnusedPlanBalance;
use Commet\Models\CreatePlanParamsUnusedPlanCredits;
use Commet\Models\CreatePlanVersionParamsCurrenciesItem;
use Commet\Models\CreatePlanVersionParamsPricesItem;
use Commet\Models\DeletedObject;
use Commet\Models\DeletedPlanRegionalPricing;
use Commet\Models\KeptOnVersion;
use Commet\Models\Plan;
use Commet\Models\PlanDraft;
use Commet\Models\PlanDraftPublication;
use Commet\Models\PlanExperiment;
use Commet\Models\PlanExperimentArchive;
use Commet\Models\PlanFeature;
use Commet\Models\PlanMove;
use Commet\Models\PlanPrice;
use Commet\Models\PlanRegionalPricing;
use Commet\Models\PlanRegionalPricingResult;
use Commet\Models\PlanVersion;
use Commet\Models\PlanVersionComparison;
use Commet\Models\PlansListDraftsResult;
use Commet\Models\PlansListExperimentsResult;
use Commet\Models\PlansListMovesResult;
use Commet\Models\PlansListResult;
use Commet\Models\PlansListSubscribersNeedingAChangeResult;
use Commet\Models\PlansListVersionsResult;
use Commet\Models\PublishPlanDraftParamsChangesItem;
use Commet\Models\RemovedPlanFeature;
use Commet\Models\SetPlanRegionalPricingParamsFeaturesItem;
use Commet\Models\SetPlanRegionalPricingParamsPricesItem;
use Commet\Models\UpdatePlanDraftParamsCountriesItem;
use Commet\Models\UpdatePlanDraftParamsPricesItem;
use Commet\Models\UpdatePlanDraftParamsRules;
use Commet\Models\UpdatePlanFeatureParamsOverage;
use Commet\Models\UpdatePlanParamsPlanBalanceLimit;
use Commet\Models\UpdatePlanParamsPlanCreditLimit;
use Commet\Models\UpdatePlanParamsUnusedPlanBalance;
use Commet\Models\UpdatePlanParamsUnusedPlanCredits;
use Commet\Models\UpdatePlanPriceParamsMarketPricesItem;
use Commet\Models\UpsertRegionalPricesParamsOverridesItem;

class PlansResource
{
    public function __construct(
        private readonly HttpClient $http,
    ) {}

    /**
     * Publish a draft as the plan's current version, as a new experiment with its own code, or as the next version of the experiment it started from. A country missing a price, or removing the signup trial of the plan's group from the current version, stops the publication. With move, subscribers of earlier versions move at their renewal or now; if any of them does not fit the new version, nothing is published and the response lists each one with what would make it fit, to send back in changes. Paused subscribers stay where they are. Send preview to check without publishing.
     * @param PublishPlanDraftParamsChangesItem[]|null $changes
     * @return PlanDraftPublication
     */
    public function publishDraft(
        string $id,
        string $draftId,
        string $publishAs,
        ?string $move = null,
        ?array $changes = null,
        ?bool $preview = null,
        ?string $experimentCode = null,
        ?string $idempotencyKey = null,
    ): PlanDraftPublication {
        $response = $this->http->post(
            "/plans/{$id}/drafts/{$draftId}/publish",
            HttpClient::buildBody([
                "publish_as" => $publishAs,
                "move" => $move,
                "changes" => $changes,
                "preview" => $preview,
                "experiment_code" => $experimentCode,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid PlanDraftPublication response payload");
        }

        return PlanDraftPublication::fromArray($response->data);
    }

    /**
     * Retrieve a draft with the version it started from and what it changes.
     * @return PlanDraft
     */
    public function getDraft(
        string $id,
        string $draftId,
    ): PlanDraft {
        $response = $this->http->get(
            "/plans/{$id}/drafts/{$draftId}",
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid PlanDraft response payload");
        }

        return PlanDraft::fromArray($response->data);
    }

    /**
     * Change a draft's prices per interval, trials, the interval shown first, countries with their currency and prices, and credit or balance rules, or undo single changes. Each block sent replaces that block; blocks left out stay as they are. Buyers and subscribers see nothing until the draft is published.
     * @param UpdatePlanDraftParamsPricesItem[]|null $prices
     * @param UpdatePlanDraftParamsCountriesItem[]|null $countries
     * @param string[]|null $undo
     * @return PlanDraft
     */
    public function updateDraft(
        string $id,
        string $draftId,
        ?array $prices = null,
        ?array $countries = null,
        ?UpdatePlanDraftParamsRules $rules = null,
        ?array $undo = null,
        ?string $idempotencyKey = null,
    ): PlanDraft {
        $response = $this->http->patch(
            "/plans/{$id}/drafts/{$draftId}",
            HttpClient::buildBody([
                "prices" => $prices,
                "countries" => $countries,
                "rules" => $rules,
                "undo" => $undo,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid PlanDraft response payload");
        }

        return PlanDraft::fromArray($response->data);
    }

    /**
     * Discard a draft. Nothing it changed was ever sold.
     * @return DeletedObject
     */
    public function deleteDraft(
        string $id,
        string $draftId,
    ): DeletedObject {
        $response = $this->http->delete(
            "/plans/{$id}/drafts/{$draftId}",
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid DeletedObject response payload");
        }

        return DeletedObject::fromArray($response->data);
    }

    /**
     * List the plan's open drafts, oldest first, each with the version it started from and what it changes. Drafts sell nothing until published.
     * @return PlansListDraftsResult
     */
    public function listDrafts(
        string $id,
    ): PlansListDraftsResult {
        $response = $this->http->get(
            "/plans/{$id}/drafts",
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid PlansListDraftsResult response payload");
        }

        return PlansListDraftsResult::fromArray($response->data);
    }

    /**
     * Start a draft from a version of the plan: the current one, an experiment's version or an older one. A plan can have any number of drafts. Edit it, then publish it as the current version, as an experiment or as an experiment's next version; nothing changes for buyers or subscribers until then.
     * @return PlanDraft
     */
    public function createDraft(
        string $id,
        ?string $fromVersionId = null,
        ?string $idempotencyKey = null,
    ): PlanDraft {
        $response = $this->http->post(
            "/plans/{$id}/drafts",
            HttpClient::buildBody([
                "from_version_id" => $fromVersionId,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid PlanDraft response payload");
        }

        return PlanDraft::fromArray($response->data);
    }

    /**
     * Stop selling the experiment. Its code sells the plan's current version from then on, so links already shared keep working. Choose what happens to its subscribers: keep them on its versions, or move them to the current version at their renewal or now. If any of them does not fit, nothing changes and the response lists each one with what would make it fit, to send back in changes.
     * @param ArchivePlanExperimentParamsChangesItem[]|null $changes
     * @return PlanExperimentArchive
     */
    public function archiveExperiment(
        string $id,
        string $code,
        ?string $subscribers = null,
        ?array $changes = null,
        ?bool $preview = null,
        ?string $idempotencyKey = null,
    ): PlanExperimentArchive {
        $response = $this->http->post(
            "/plans/{$id}/experiments/{$code}/archive",
            HttpClient::buildBody([
                "subscribers" => $subscribers,
                "changes" => $changes,
                "preview" => $preview,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid PlanExperimentArchive response payload");
        }

        return PlanExperimentArchive::fromArray($response->data);
    }

    /**
     * Make the experiment's latest version the plan's current version, with exactly its content and the next version number. New buyers get it; its subscribers are already on it. The experiment closes, and its code sells the plan's current version from then on. Nobody else moves.
     * @return PlanVersion
     */
    public function makeExperimentCurrent(
        string $id,
        string $code,
        ?string $idempotencyKey = null,
    ): PlanVersion {
        $response = $this->http->post(
            "/plans/{$id}/experiments/{$code}/make-current",
            idempotencyKey: $idempotencyKey,
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid PlanVersion response payload");
        }

        return PlanVersion::fromArray($response->data);
    }

    /**
     * Get one experiment of a plan by its own code, with the version it sells and how many subscriptions are on it.
     * @return PlanExperiment
     */
    public function getExperiment(
        string $id,
        string $code,
    ): PlanExperiment {
        $response = $this->http->get(
            "/plans/{$id}/experiments/{$code}",
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid PlanExperiment response payload");
        }

        return PlanExperiment::fromArray($response->data);
    }

    /**
     * Publish the experiment's next version from its latest version with the changes given. Its code sells the new version from now on; subscribers on its earlier versions stay where they are until moved.
     * @param CreatePlanExperimentVersionParamsPricesItem[]|null $prices
     * @param CreatePlanExperimentVersionParamsCurrenciesItem[]|null $currencies
     * @return PlanVersion
     */
    public function createExperimentVersion(
        string $id,
        string $code,
        ?array $prices = null,
        ?array $currencies = null,
        ?int $maxPlanCredits = null,
        ?int $maxPlanBalance = null,
        ?string $idempotencyKey = null,
    ): PlanVersion {
        $response = $this->http->post(
            "/plans/{$id}/experiments/{$code}/versions",
            HttpClient::buildBody([
                "prices" => $prices,
                "currencies" => $currencies,
                "max_plan_credits" => $maxPlanCredits,
                "max_plan_balance" => $maxPlanBalance,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid PlanVersion response payload");
        }

        return PlanVersion::fromArray($response->data);
    }

    /**
     * List a plan's experiments, newest first, with the version each one sells and how many subscriptions are on them.
     * @return PlansListExperimentsResult
     */
    public function listExperiments(
        string $id,
    ): PlansListExperimentsResult {
        $response = $this->http->get(
            "/plans/{$id}/experiments",
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid PlansListExperimentsResult response payload");
        }

        return PlansListExperimentsResult::fromArray($response->data);
    }

    /**
     * Start an experiment from the plan's current version with the changes given. It is sold only through its code (planCode `<plan code>:<code>`); new buyers of the plan keep getting the current version.
     * @param CreatePlanExperimentParamsPricesItem[]|null $prices
     * @param CreatePlanExperimentParamsCurrenciesItem[]|null $currencies
     * @return PlanExperiment
     */
    public function createExperiment(
        string $id,
        string $code,
        ?array $prices = null,
        ?array $currencies = null,
        ?int $maxPlanCredits = null,
        ?int $maxPlanBalance = null,
        ?string $idempotencyKey = null,
    ): PlanExperiment {
        $response = $this->http->post(
            "/plans/{$id}/experiments",
            HttpClient::buildBody([
                "prices" => $prices,
                "currencies" => $currencies,
                "max_plan_credits" => $maxPlanCredits,
                "max_plan_balance" => $maxPlanBalance,
                "code" => $code,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid PlanExperiment response payload");
        }

        return PlanExperiment::fromArray($response->data);
    }

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
     * Cancel a move for every subscriber who has not moved yet. They stay on their version; those already moved stay moved.
     * @return PlanMove
     */
    public function cancelMove(
        string $id,
        string $moveId,
        ?string $idempotencyKey = null,
    ): PlanMove {
        $response = $this->http->post(
            "/plans/{$id}/moves/{$moveId}/cancel",
            idempotencyKey: $idempotencyKey,
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid PlanMove response payload");
        }

        return PlanMove::fromArray($response->data);
    }

    /**
     * Read a move of subscribers between plan versions with each subscriber's status: moving, moved, needs a change, left out, canceled or kept on its version.
     * @return PlanMove
     */
    public function getMove(
        string $id,
        string $moveId,
    ): PlanMove {
        $response = $this->http->get(
            "/plans/{$id}/moves/{$moveId}",
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid PlanMove response payload");
        }

        return PlanMove::fromArray($response->data);
    }

    /**
     * Cancel a move for one subscriber who has not moved yet. It stays on its version; the rest of the move continues.
     * @return PlanMove
     */
    public function cancelMoveSubscription(
        string $id,
        string $moveId,
        string $subscriptionId,
        ?string $idempotencyKey = null,
    ): PlanMove {
        $response = $this->http->post(
            "/plans/{$id}/moves/{$moveId}/subscriptions/{$subscriptionId}/cancel",
            idempotencyKey: $idempotencyKey,
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid PlanMove response payload");
        }

        return PlanMove::fromArray($response->data);
    }

    /**
     * List a plan's latest moves of subscribers between versions, newest first, with how many are moving, moved, need a change, were left out, canceled or kept on their version.
     * @return PlansListMovesResult
     */
    public function listMoves(
        string $id,
    ): PlansListMovesResult {
        $response = $this->http->get(
            "/plans/{$id}/moves",
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid PlansListMovesResult response payload");
        }

        return PlansListMovesResult::fromArray($response->data);
    }

    /**
     * Move a list of subscriptions, or every subscription of another version, to a newer version of the plan, at their next renewal or now. Nobody moves unless every one of them fits or has a change in changes; otherwise the response lists each one with what would make it fit. Only active, trialing and past due subscriptions move. Paused ones, and listed subscriptions in another status or already on the destination, are left out. Send preview to check without moving anyone.
     * @param string[]|null $subscriptionIds
     * @param CreatePlanMoveParamsChangesItem[]|null $changes
     * @return PlanMove
     */
    public function createMove(
        string $id,
        string $toVersionId,
        string $effective,
        ?array $subscriptionIds = null,
        ?array $changes = null,
        ?bool $preview = null,
        ?string $fromVersionId = null,
        ?string $idempotencyKey = null,
    ): PlanMove {
        $response = $this->http->post(
            "/plans/{$id}/moves",
            HttpClient::buildBody([
                "subscription_ids" => $subscriptionIds,
                "to_version_id" => $toVersionId,
                "effective" => $effective,
                "changes" => $changes,
                "preview" => $preview,
                "from_version_id" => $fromVersionId,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid PlanMove response payload");
        }

        return PlanMove::fromArray($response->data);
    }

    /**
     * Leave a subscriber that needs a change on its version. It stops appearing among the subscribers that need a change; move it later like any other subscriber.
     * @return KeptOnVersion
     */
    public function keepSubscriberOnVersion(
        string $id,
        string $subscriptionId,
        ?string $idempotencyKey = null,
    ): KeptOnVersion {
        $response = $this->http->post(
            "/plans/{$id}/needs-a-change/{$subscriptionId}/keep",
            idempotencyKey: $idempotencyKey,
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid KeptOnVersion response payload");
        }

        return KeptOnVersion::fromArray($response->data);
    }

    /**
     * List the plan's subscribers whose move could not complete, with the version they stay on, the one they could not move to and why. Move them again with a change, or keep them on their version so they leave this list.
     * @return PlansListSubscribersNeedingAChangeResult
     */
    public function listSubscribersNeedingAChange(
        string $id,
    ): PlansListSubscribersNeedingAChangeResult {
        $response = $this->http->get(
            "/plans/{$id}/needs-a-change",
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid PlansListSubscribersNeedingAChangeResult response payload");
        }

        return PlansListSubscribersNeedingAChangeResult::fromArray($response->data);
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
        ?bool $trialRequiresPaymentMethod = null,
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
                "trial_requires_payment_method" => $trialRequiresPaymentMethod,
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
     * Archive a price for new subscriptions. This publishes a new version of the plan; existing subscriptions that selected the price keep paying it on their version until moved.
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
        ?bool $trialRequiresPaymentMethod = null,
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
                "trial_requires_payment_method" => $trialRequiresPaymentMethod,
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
     * Update a plan's name, description, visibility, default status, metadata, overage behavior, what happens to its unused plan credits or plan balance, or its plan credit or plan balance limit.
     * @param array<string, mixed>|null $metadata
     * @return Plan
     */
    public function update(
        string $id,
        ?string $name = null,
        ?string $description = null,
        ?array $metadata = null,
        ?bool $isPublic = null,
        ?UpdatePlanParamsUnusedPlanCredits $unusedPlanCredits = null,
        ?UpdatePlanParamsPlanCreditLimit $planCreditLimit = null,
        ?UpdatePlanParamsUnusedPlanBalance $unusedPlanBalance = null,
        ?UpdatePlanParamsPlanBalanceLimit $planBalanceLimit = null,
        ?bool $blockOnExhaustion = null,
        ?bool $isDefault = null,
        ?string $idempotencyKey = null,
    ): Plan {
        $response = $this->http->patch(
            "/plans/{$id}",
            HttpClient::buildBody([
                "name" => $name,
                "description" => $description,
                "metadata" => $metadata,
                "is_public" => $isPublic,
                "unused_plan_credits" => $unusedPlanCredits,
                "plan_credit_limit" => $planCreditLimit,
                "unused_plan_balance" => $unusedPlanBalance,
                "plan_balance_limit" => $planBalanceLimit,
                "block_on_exhaustion" => $blockOnExhaustion,
                "is_default" => $isDefault,
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
     * List what changes from one version of a plan to another: prices, trials, features, rules, add-ons, credit packs and countries.
     * @return PlanVersionComparison
     */
    public function compareVersions(
        string $id,
        string $versionId,
        string $against,
    ): PlanVersionComparison {
        $response = $this->http->get(
            "/plans/{$id}/versions/{$versionId}/changes",
            HttpClient::buildBody([
                "against" => $against,
            ]),
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid PlanVersionComparison response payload");
        }

        return PlanVersionComparison::fromArray($response->data);
    }

    /**
     * Get one published version of a plan with its prices and how many subscriptions are on it.
     * @return PlanVersion
     */
    public function getVersion(
        string $id,
        string $versionId,
    ): PlanVersion {
        $response = $this->http->get(
            "/plans/{$id}/versions/{$versionId}",
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid PlanVersion response payload");
        }

        return PlanVersion::fromArray($response->data);
    }

    /**
     * List a plan's published versions, newest first, with their prices and how many subscriptions are on each. Versions published before Commet recorded every term are not listed.
     * @return PlansListVersionsResult
     */
    public function listVersions(
        string $id,
        ?string $cursor = null,
        ?int $limit = null,
    ): PlansListVersionsResult {
        $response = $this->http->get(
            "/plans/{$id}/versions",
            HttpClient::buildBody([
                "cursor" => $cursor,
                "limit" => $limit,
            ]),
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid PlansListVersionsResult response payload");
        }

        return PlansListVersionsResult::fromArray($response->data);
    }

    /**
     * Publish a new current version of the plan from its current version, changing prices per interval, included credits or balance, per-currency amounts and the rollover cap. New buyers get it; every subscriber stays on its version until moved. To try changes without selling them to everyone, create an experiment instead.
     * @param CreatePlanVersionParamsPricesItem[]|null $prices
     * @param CreatePlanVersionParamsCurrenciesItem[]|null $currencies
     * @return PlanVersion
     */
    public function createVersion(
        string $id,
        ?array $prices = null,
        ?array $currencies = null,
        ?int $maxPlanCredits = null,
        ?int $maxPlanBalance = null,
        ?string $idempotencyKey = null,
    ): PlanVersion {
        $response = $this->http->post(
            "/plans/{$id}/versions",
            HttpClient::buildBody([
                "prices" => $prices,
                "currencies" => $currencies,
                "max_plan_credits" => $maxPlanCredits,
                "max_plan_balance" => $maxPlanBalance,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid PlanVersion response payload");
        }

        return PlanVersion::fromArray($response->data);
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
     * Create a new plan with optional consumption model, visibility, plan group assignment, overage behavior, and the rollover and spend limit of its plan credits or plan balance.
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
        ?CreatePlanParamsUnusedPlanCredits $unusedPlanCredits = null,
        ?CreatePlanParamsPlanCreditLimit $planCreditLimit = null,
        ?CreatePlanParamsUnusedPlanBalance $unusedPlanBalance = null,
        ?CreatePlanParamsPlanBalanceLimit $planBalanceLimit = null,
        ?string $planGroupId = null,
        ?bool $isDefault = null,
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
                "unused_plan_credits" => $unusedPlanCredits,
                "plan_credit_limit" => $planCreditLimit,
                "unused_plan_balance" => $unusedPlanBalance,
                "plan_balance_limit" => $planBalanceLimit,
                "plan_group_id" => $planGroupId,
                "is_default" => $isDefault,
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
