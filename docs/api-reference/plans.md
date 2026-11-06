# Plans

API version: `2026-08-27`

## publishDraft

`$commet->plans->publishDraft(...)`

`POST /plans/{id}/drafts/{draftId}/publish` · operation `publish-plan-draft`

Publish a draft as the plan's current version, as a new experiment with its own code, or as the next version of the experiment it started from. A country missing a price, or removing the signup trial of the plan's group from the current version, stops the publication. With move, subscribers of earlier versions move at their renewal or now; if any of them does not fit the new version, nothing is published and the response lists each one with what would make it fit, to send back in changes. Paused subscribers stay where they are. Send preview to check without publishing.

### Parameters

- `id` (`string`, required)
- `draftId` (`string`, required)
- `publishAs` (`string`, required) — current sells the draft to every new buyer.
- `move` (`string`, optional) — What happens to subscribers of earlier versions: keep them, move them at their next renewal, or move them now (features and balance change today, the price at renewal). Nobody moves unless every one of them fits or has a change below.
- `changes` (`array`, optional) — Per-subscriber changes that make each one fit, applied at its renewal.
- `preview` (`bool`, optional) — Check everything without publishing.
- `experimentCode` (`string`, optional) — The experiment's own code, after the plan's code.

### Valid parameter combinations

- `publishAs`
- `publishAs` + `experimentCode`
- `publishAs`

### Request options

- `idempotencyKey` (`string`, optional) — Unique key used to safely retry this write for 24 hours without applying it twice.

### Returns

`PlanDraftPublication`

## getDraft

`$commet->plans->getDraft(...)`

`GET /plans/{id}/drafts/{draftId}` · operation `get-plan-draft`

Retrieve a draft with the version it started from and what it changes.

### Parameters

- `id` (`string`, required)
- `draftId` (`string`, required)

### Returns

`PlanDraft`

## updateDraft

`$commet->plans->updateDraft(...)`

`PATCH /plans/{id}/drafts/{draftId}` · operation `update-plan-draft`

Change a draft's prices per interval, trials, the interval shown first, countries with their currency and prices, and credit or balance rules, or undo single changes. Each block sent replaces that block; blocks left out stay as they are. Buyers and subscribers see nothing until the draft is published.

### Parameters

- `id` (`string`, required)
- `draftId` (`string`, required)
- `prices` (`array`, optional) — Every interval the draft sells. An interval the draft sold and this list leaves out is removed from the draft.
- `countries` (`array`, optional) — Every country with its own currency or prices. A country the draft sold and this list leaves out is removed. A country missing a price blocks publishing.
- `rules` (`UpdatePlanDraftParamsRules`, optional) — Credit or balance rules; fields left out stay as they are.
- `undo` (`array`, optional) — Change keys to put back as the version the draft started from had them.

### Request options

- `idempotencyKey` (`string`, optional) — Unique key used to safely retry this write for 24 hours without applying it twice.

### Returns

`PlanDraft`

## deleteDraft

`$commet->plans->deleteDraft(...)`

`DELETE /plans/{id}/drafts/{draftId}` · operation `delete-plan-draft`

Discard a draft. Nothing it changed was ever sold.

### Parameters

- `id` (`string`, required)
- `draftId` (`string`, required)

### Returns

`DeletedObject`

## listDrafts

`$commet->plans->listDrafts(...)`

`GET /plans/{id}/drafts` · operation `list-plan-drafts`

List the plan's open drafts, oldest first, each with the version it started from and what it changes. Drafts sell nothing until published.

### Parameters

- `id` (`string`, required)

### Returns

`PlansListDraftsResult`

## createDraft

`$commet->plans->createDraft(...)`

`POST /plans/{id}/drafts` · operation `create-plan-draft`

Start a draft from a version of the plan: the current one, an experiment's version or an older one. A plan can have any number of drafts. Edit it, then publish it as the current version, as an experiment or as an experiment's next version; nothing changes for buyers or subscribers until then.

### Parameters

- `id` (`string`, required)
- `fromVersionId` (`string`, optional) — The version to start from: the current version, an experiment's version or an older version. Defaults to the current version.

### Request options

- `idempotencyKey` (`string`, optional) — Unique key used to safely retry this write for 24 hours without applying it twice.

### Returns

`PlanDraft`

## archiveExperiment

`$commet->plans->archiveExperiment(...)`

`POST /plans/{id}/experiments/{code}/archive` · operation `archive-plan-experiment`

Stop selling the experiment. Its code sells the plan's current version from then on, so links already shared keep working. Choose what happens to its subscribers: keep them on its versions, or move them to the current version at their renewal or now. If any of them does not fit, nothing changes and the response lists each one with what would make it fit, to send back in changes.

### Parameters

- `id` (`string`, required)
- `code` (`string`, required)
- `subscribers` (`string`, optional) — What happens to the experiment's subscribers: keep them on its versions, move them to the plan's current version at their next renewal, or move them now. Nobody moves, and the experiment keeps running, unless every one of them fits or has a change.
- `changes` (`array`, optional) — Per-subscriber changes that make each one fit, applied at its renewal.
- `preview` (`bool`, optional) — Check the archive and the move without changing anything.

### Request options

- `idempotencyKey` (`string`, optional) — Unique key used to safely retry this write for 24 hours without applying it twice.

### Returns

`PlanExperimentArchive`

## makeExperimentCurrent

`$commet->plans->makeExperimentCurrent(...)`

`POST /plans/{id}/experiments/{code}/make-current` · operation `make-plan-experiment-current`

Make the experiment's latest version the plan's current version, with exactly its content and the next version number. New buyers get it; its subscribers are already on it. The experiment closes, and its code sells the plan's current version from then on. Nobody else moves.

### Parameters

- `id` (`string`, required)
- `code` (`string`, required)

### Request options

- `idempotencyKey` (`string`, optional) — Unique key used to safely retry this write for 24 hours without applying it twice.

### Returns

`PlanVersion`

## getExperiment

`$commet->plans->getExperiment(...)`

`GET /plans/{id}/experiments/{code}` · operation `get-plan-experiment`

Get one experiment of a plan by its own code, with the version it sells and how many subscriptions are on it.

### Parameters

- `id` (`string`, required)
- `code` (`string`, required)

### Returns

`PlanExperiment`

## createExperimentVersion

`$commet->plans->createExperimentVersion(...)`

`POST /plans/{id}/experiments/{code}/versions` · operation `create-plan-experiment-version`

Publish the experiment's next version from its latest version with the changes given. Its code sells the new version from now on; subscribers on its earlier versions stay where they are until moved.

### Parameters

- `id` (`string`, required)
- `code` (`string`, required)
- `prices` (`array`, optional)
- `currencies` (`array`, optional) — Currencies the current version does not sell, with the exchange rate (local units per USD) used for the amounts not listed, credit purchases, add-ons and overage.
- `maxPlanCredits` (`int | null`, optional) — Credits plans that roll over unused credits: the most plan credits a subscription can hold. Null removes the cap.
- `maxPlanBalance` (`int | null`, optional) — Balance plans that roll over unused balance: the most plan balance a subscription can hold, in USD cents. Other currencies convert it with the plan's exchange rate unless the dashboard sets a custom amount for that currency. Null removes the cap.

### Request options

- `idempotencyKey` (`string`, optional) — Unique key used to safely retry this write for 24 hours without applying it twice.

### Returns

`PlanVersion`

## listExperiments

`$commet->plans->listExperiments(...)`

`GET /plans/{id}/experiments` · operation `list-plan-experiments`

List a plan's experiments, newest first, with the version each one sells and how many subscriptions are on them.

### Parameters

- `id` (`string`, required)

### Returns

`PlansListExperimentsResult`

## createExperiment

`$commet->plans->createExperiment(...)`

`POST /plans/{id}/experiments` · operation `create-plan-experiment`

Start an experiment from the plan's current version with the changes given. It is sold only through its code (planCode `<plan code>:<code>`); new buyers of the plan keep getting the current version.

### Parameters

- `id` (`string`, required)
- `prices` (`array`, optional)
- `currencies` (`array`, optional) — Currencies the current version does not sell, with the exchange rate (local units per USD) used for the amounts not listed, credit purchases, add-ons and overage.
- `maxPlanCredits` (`int | null`, optional) — Credits plans that roll over unused credits: the most plan credits a subscription can hold. Null removes the cap.
- `maxPlanBalance` (`int | null`, optional) — Balance plans that roll over unused balance: the most plan balance a subscription can hold, in USD cents. Other currencies convert it with the plan's exchange rate unless the dashboard sets a custom amount for that currency. Null removes the cap.
- `code` (`string`, required) — The experiment's own code: lowercase letters, numbers, hyphens and underscores. It is sold as planCode `<plan code>:<code>` and is never reused in the plan.

### Request options

- `idempotencyKey` (`string`, optional) — Unique key used to safely retry this write for 24 hours without applying it twice.

### Returns

`PlanExperiment`

## updateFeature

`$commet->plans->updateFeature(...)`

`PATCH /plans/{id}/features/{featureId}` · operation `update-plan-feature`

Update limits, overage, or enabled status of a feature on a plan.

### Parameters

- `id` (`string`, required)
- `featureId` (`string`, required)
- `enabled` (`bool`, optional)
- `includedAmount` (`int`, optional)
- `unlimited` (`bool`, optional)
- `overage` (`UpdatePlanFeatureParamsOverage`, optional)
- `creditsPerUnit` (`int | null`, optional)

### Request options

- `idempotencyKey` (`string`, optional) — Unique key used to safely retry this write for 24 hours without applying it twice.

### Returns

`PlanFeature`

## removeFeature

`$commet->plans->removeFeature(...)`

`DELETE /plans/{id}/features/{featureId}` · operation `remove-plan-feature`

Detach a feature from a plan.

### Parameters

- `id` (`string`, required)
- `featureId` (`string`, required)

### Returns

`RemovedPlanFeature`

## addFeature

`$commet->plans->addFeature(...)`

`POST /plans/{id}/features` · operation `add-plan-feature`

Attach a feature to a plan with limits, overage, and credits configuration.

### Parameters

- `id` (`string`, required)
- `featureId` (`string`, required)
- `enabled` (`bool`, optional)
- `includedAmount` (`int`, optional)
- `unlimited` (`bool`, optional)
- `overage` (`AddPlanFeatureParamsOverage`, optional)
- `creditsPerUnit` (`int | null`, optional)
- `pricingMode` (`string`, optional)
- `margin` (`int | null`, optional)

### Request options

- `idempotencyKey` (`string`, optional) — Unique key used to safely retry this write for 24 hours without applying it twice.

### Returns

`PlanFeature`

## cancelMove

`$commet->plans->cancelMove(...)`

`POST /plans/{id}/moves/{moveId}/cancel` · operation `cancel-plan-move`

Cancel a move for every subscriber who has not moved yet. They stay on their version; those already moved stay moved.

### Parameters

- `id` (`string`, required)
- `moveId` (`string`, required)

### Request options

- `idempotencyKey` (`string`, optional) — Unique key used to safely retry this write for 24 hours without applying it twice.

### Returns

`PlanMove`

## getMove

`$commet->plans->getMove(...)`

`GET /plans/{id}/moves/{moveId}` · operation `get-plan-move`

Read a move of subscribers between plan versions with each subscriber's status: moving, moved, needs a change, left out, canceled or kept on its version.

### Parameters

- `id` (`string`, required)
- `moveId` (`string`, required)

### Returns

`PlanMove`

## cancelMoveSubscription

`$commet->plans->cancelMoveSubscription(...)`

`POST /plans/{id}/moves/{moveId}/subscriptions/{subscriptionId}/cancel` · operation `cancel-plan-move-subscription`

Cancel a move for one subscriber who has not moved yet. It stays on its version; the rest of the move continues.

### Parameters

- `id` (`string`, required)
- `moveId` (`string`, required)
- `subscriptionId` (`string`, required)

### Request options

- `idempotencyKey` (`string`, optional) — Unique key used to safely retry this write for 24 hours without applying it twice.

### Returns

`PlanMove`

## listMoves

`$commet->plans->listMoves(...)`

`GET /plans/{id}/moves` · operation `list-plan-moves`

List a plan's latest moves of subscribers between versions, newest first, with how many are moving, moved, need a change, were left out, canceled or kept on their version.

### Parameters

- `id` (`string`, required)

### Returns

`PlansListMovesResult`

## createMove

`$commet->plans->createMove(...)`

`POST /plans/{id}/moves` · operation `create-plan-move`

Move a list of subscriptions, or every subscription of another version, to a newer version of the plan, at their next renewal or now. Nobody moves unless every one of them fits or has a change in changes; otherwise the response lists each one with what would make it fit. Only active, trialing and past due subscriptions move. Paused ones, and listed subscriptions in another status or already on the destination, are left out. Send preview to check without moving anyone.

### Parameters

- `id` (`string`, required)
- `subscriptionIds` (`array`, optional) — Public IDs of the subscriptions to move.
- `toVersionId` (`string`, required) — The version subscribers move to.
- `effective` (`string`, required) — now changes features and the included amount today and the price at renewal; period_end moves each subscriber at its next renewal.
- `changes` (`array`, optional) — Per-subscriber changes that make each one fit, applied at its renewal.
- `preview` (`bool`, optional) — Check every subscriber without moving anyone.
- `fromVersionId` (`string`, optional) — Move every active, trialing and past due subscription on this version of the plan.

### Valid parameter combinations

- `subscriptionIds` + `toVersionId` + `effective`
- `fromVersionId` + `toVersionId` + `effective`

### Request options

- `idempotencyKey` (`string`, optional) — Unique key used to safely retry this write for 24 hours without applying it twice.

### Returns

`PlanMove`

## keepSubscriberOnVersion

`$commet->plans->keepSubscriberOnVersion(...)`

`POST /plans/{id}/needs-a-change/{subscriptionId}/keep` · operation `keep-plan-subscriber-on-version`

Leave a subscriber that needs a change on its version. It stops appearing among the subscribers that need a change; move it later like any other subscriber.

### Parameters

- `id` (`string`, required)
- `subscriptionId` (`string`, required)

### Request options

- `idempotencyKey` (`string`, optional) — Unique key used to safely retry this write for 24 hours without applying it twice.

### Returns

`KeptOnVersion`

## listSubscribersNeedingAChange

`$commet->plans->listSubscribersNeedingAChange(...)`

`GET /plans/{id}/needs-a-change` · operation `list-plan-subscribers-needing-a-change`

List the plan's subscribers whose move could not complete, with the version they stay on, the one they could not move to and why. Move them again with a change, or keep them on their version so they leave this list.

### Parameters

- `id` (`string`, required)

### Returns

`PlansListSubscribersNeedingAChangeResult`

## setDefaultPrice

`$commet->plans->setDefaultPrice(...)`

`PUT /plans/{id}/prices/{priceId}/default` · operation `set-default-plan-price`

Set a specific price as the default and return the updated plan price.

### Parameters

- `id` (`string`, required)
- `priceId` (`string`, required)

### Request options

- `idempotencyKey` (`string`, optional) — Unique key used to safely retry this write for 24 hours without applying it twice.

### Returns

`PlanPrice`

## setRegionalPrices

`$commet->plans->setRegionalPrices(...)`

`PUT /plans/{id}/prices/{priceId}/regional` · operation `upsert-regional-prices`

Create or update regional currency price overrides for a plan price.

### Parameters

- `id` (`string`, required)
- `priceId` (`string`, required)
- `overrides` (`array`, required)

### Request options

- `idempotencyKey` (`string`, optional) — Unique key used to safely retry this write for 24 hours without applying it twice.

### Returns

`PlanRegionalPricing`

## deleteRegionalPrices

`$commet->plans->deleteRegionalPrices(...)`

`DELETE /plans/{id}/prices/{priceId}/regional` · operation `delete-regional-prices`

Remove all regional currency overrides for a plan price. The request is rejected while billable subscriptions depend on an override.

### Parameters

- `id` (`string`, required)
- `priceId` (`string`, required)

### Returns

`DeletedPlanRegionalPricing`

## updatePrice

`$commet->plans->updatePrice(...)`

`PATCH /plans/{id}/prices/{priceId}` · operation `update-plan-price`

Update a base price or market price variant. Removing a base market override is rejected while a variant depends on it. Offer terms are managed through Offers.

### Parameters

- `id` (`string`, required)
- `priceId` (`string`, required)
- `price` (`int`, optional)
- `isDefault` (`bool`, optional)
- `trialDays` (`int`, optional)
- `trialRequiresPaymentMethod` (`bool`, optional) — Set to false so the price's free trial starts without a payment method. Requires trialDays on the price.
- `includedBalance` (`int | null`, optional)
- `includedCredits` (`int | null`, optional)
- `metadata` (`array`, optional) — Metadata keys to merge into the existing price metadata.
- `marketPrices` (`array`, optional)

### Request options

- `idempotencyKey` (`string`, optional) — Unique key used to safely retry this write for 24 hours without applying it twice.

### Returns

`PlanPrice`

## deletePrice

`$commet->plans->deletePrice(...)`

`DELETE /plans/{id}/prices/{priceId}` · operation `delete-plan-price`

Archive a price for new subscriptions. This publishes a new version of the plan; existing subscriptions that selected the price keep paying it on their version until moved.

### Parameters

- `id` (`string`, required)
- `priceId` (`string`, required)

### Returns

`DeletedObject`

## addPrice

`$commet->plans->addPrice(...)`

`POST /plans/{id}/prices` · operation `add-plan-price`

Add a base price or a selectable market price variant. Variants inherit their base price outside the markets they override. Configure introductory and promotional benefits through Offers.

### Parameters

- `id` (`string`, required)
- `billingInterval` (`string`, required)
- `metadata` (`array`, optional)
- `price` (`int`, optional)
- `trialDays` (`int`, optional)
- `trialRequiresPaymentMethod` (`bool`, optional) — Set to false so the price's free trial starts without a payment method. Requires trialDays on the price.
- `isDefault` (`bool`, optional)
- `includedBalance` (`int | null`, optional)
- `includedCredits` (`int | null`, optional)
- `marketPrices` (`array`, optional)
- `inheritsFromPriceId` (`string`, optional)

### Valid parameter combinations

- `billingInterval` + `price`
- `billingInterval` + `inheritsFromPriceId` + `marketPrices`

### Request options

- `idempotencyKey` (`string`, optional) — Unique key used to safely retry this write for 24 hours without applying it twice.

### Returns

`PlanPrice`

## setRegionalPricing

`$commet->plans->setRegionalPricing(...)`

`PUT /plans/{id}/regional` · operation `set-plan-regional-pricing`

Configure regional prices and feature overage values for one currency. Currency-specific offer terms are managed through Offers.

### Parameters

- `id` (`string`, required)
- `currency` (`string`, required)
- `exchangeRate` (`float`, required)
- `prices` (`array`, optional)
- `features` (`array`, optional)

### Request options

- `idempotencyKey` (`string`, optional) — Unique key used to safely retry this write for 24 hours without applying it twice.

### Returns

`PlanRegionalPricingResult`

## get

`$commet->plans->get(...)`

`GET /plans/{id}` · operation `get-plan`

Get a plan with public price IDs and their automatic introductory offer IDs.

### Parameters

- `id` (`string`, required)

### Returns

`Plan`

## update

`$commet->plans->update(...)`

`PATCH /plans/{id}` · operation `update-plan`

Update a plan's name, description, visibility, default status, metadata, overage behavior, what happens to its unused plan credits or plan balance, or its plan credit or plan balance limit.

### Parameters

- `id` (`string`, required)
- `name` (`string`, optional)
- `description` (`string | null`, optional)
- `metadata` (`array`, optional)
- `isPublic` (`bool`, optional)
- `unusedPlanCredits` (`UpdatePlanParamsUnusedPlanCredits`, optional) — Credits plans only. What happens to unused plan credits at each reset. Changing it publishes a new version of the plan; each subscription stays on its version until moved.
- `planCreditLimit` (`UpdatePlanParamsPlanCreditLimit | null`, optional) — Credits plans only. The most plan credits a subscription spends per day or per week; null removes the limit. Changing it publishes a new version of the plan; each subscription stays on its version until moved.
- `unusedPlanBalance` (`UpdatePlanParamsUnusedPlanBalance`, optional) — Balance plans only. What happens to unused plan balance at each reset. Changing it publishes a new version of the plan; each subscription stays on its version until moved.
- `planBalanceLimit` (`UpdatePlanParamsPlanBalanceLimit | null`, optional) — Balance plans only. The most plan balance a subscription spends per day or per week, in USD cents; null removes the limit. Changing it publishes a new version of the plan; each subscription stays on its version until moved.
- `blockOnExhaustion` (`bool`, optional) — Credits and balance plans only. false lets usage continue past the plan and purchased amounts and bills the missing amount as overage at the next renewal; a credits plan bills it at the price per credit and needs one. Trials and free plans always stop, so free plans accept only true. Changing it publishes a new version of the plan; each subscription stays on its version until moved.
- `isDefault` (`bool`, optional) — Make this plan the default plan of its plan group: customers created with that planGroupId start on it, and a paid plan of the group that ends from the customer portal, a revoked payment authorization or exhausted dunning moves to it instead of canceling. Requires a free plan in a plan group; replaces the group's previous default plan. false unmarks it.

### Request options

- `idempotencyKey` (`string`, optional) — Unique key used to safely retry this write for 24 hours without applying it twice.

### Returns

`Plan`

## delete

`$commet->plans->delete(...)`

`DELETE /plans/{id}` · operation `delete-plan`

Soft-delete a plan.

### Parameters

- `id` (`string`, required)

### Returns

`DeletedObject`

## compareVersions

`$commet->plans->compareVersions(...)`

`GET /plans/{id}/versions/{versionId}/changes` · operation `compare-plan-versions`

List what changes from one version of a plan to another: prices, trials, features, rules, add-ons, credit packs and countries.

### Parameters

- `id` (`string`, required)
- `versionId` (`string`, required)
- `against` (`string`, required)

### Returns

`PlanVersionComparison`

## getVersion

`$commet->plans->getVersion(...)`

`GET /plans/{id}/versions/{versionId}` · operation `get-plan-version`

Get one published version of a plan with its prices and how many subscriptions are on it.

### Parameters

- `id` (`string`, required)
- `versionId` (`string`, required)

### Returns

`PlanVersion`

## listVersions

`$commet->plans->listVersions(...)`

`GET /plans/{id}/versions` · operation `list-plan-versions`

List a plan's published versions, newest first, with their prices and how many subscriptions are on each. Versions published before Commet recorded every term are not listed.

### Parameters

- `id` (`string`, required)
- `cursor` (`string`, optional)
- `limit` (`int`, optional)

### Returns

`PlansListVersionsResult`

## createVersion

`$commet->plans->createVersion(...)`

`POST /plans/{id}/versions` · operation `create-plan-version`

Publish a new current version of the plan from its current version, changing prices per interval, included credits or balance, per-currency amounts and the rollover cap. New buyers get it; every subscriber stays on its version until moved. To try changes without selling them to everyone, create an experiment instead.

### Parameters

- `id` (`string`, required)
- `prices` (`array`, optional)
- `currencies` (`array`, optional) — Currencies the current version does not sell, with the exchange rate (local units per USD) used for the amounts not listed, credit purchases, add-ons and overage.
- `maxPlanCredits` (`int | null`, optional) — Credits plans that roll over unused credits: the most plan credits a subscription can hold. Null removes the cap.
- `maxPlanBalance` (`int | null`, optional) — Balance plans that roll over unused balance: the most plan balance a subscription can hold, in USD cents. Other currencies convert it with the plan's exchange rate unless the dashboard sets a custom amount for that currency. Null removes the cap.

### Request options

- `idempotencyKey` (`string`, optional) — Unique key used to safely retry this write for 24 hours without applying it twice.

### Returns

`PlanVersion`

## setVisibility

`$commet->plans->setVisibility(...)`

`PUT /plans/{id}/visibility` · operation `set-plan-visibility`

Set a plan's public visibility and return the updated plan.

### Parameters

- `id` (`string`, required)
- `isPublic` (`bool`, required)

### Request options

- `idempotencyKey` (`string`, optional) — Unique key used to safely retry this write for 24 hours without applying it twice.

### Returns

`Plan`

## list

`$commet->plans->list(...)`

`GET /plans` · operation `list-plans`

List plans with public price IDs and their automatic introductory offer IDs.

### Parameters

- `includePrivate` (`bool`, optional)

### Returns

`PlansListResult`

## create

`$commet->plans->create(...)`

`POST /plans` · operation `create-plan`

Create a new plan with optional consumption model, visibility, plan group assignment, overage behavior, and the rollover and spend limit of its plan credits or plan balance.

### Parameters

- `name` (`string`, required)
- `code` (`string`, required)
- `description` (`string`, optional)
- `consumptionModel` (`string`, optional)
- `isPublic` (`bool`, optional)
- `isFree` (`bool`, optional)
- `blockOnExhaustion` (`bool`, optional) — Credits and balance plans. Omitted, credits plans and free plans stop usage when the plan and purchased amounts run out, and paid balance plans bill the missing balance as overage. A new credits plan always stops usage: it allows overage only with a price per credit, which is set after creation, and then `PATCH /v1/plans/{id}` turns overage on.
- `unusedPlanCredits` (`CreatePlanParamsUnusedPlanCredits`, optional) — Credits plans only. What happens to unused plan credits at each reset; omitted means they expire.
- `planCreditLimit` (`CreatePlanParamsPlanCreditLimit | null`, optional) — Credits plans only. The most plan credits a subscription spends per day or per week; omitted or null means no limit.
- `unusedPlanBalance` (`CreatePlanParamsUnusedPlanBalance`, optional) — Balance plans only. What happens to unused plan balance at each reset; omitted means it expires.
- `planBalanceLimit` (`CreatePlanParamsPlanBalanceLimit | null`, optional) — Balance plans only. The most plan balance a subscription spends per day or per week, in USD cents; omitted or null means no limit.
- `planGroupId` (`string`, optional)
- `isDefault` (`bool`, optional) — Make this plan the default plan of its plan group: customers created with that planGroupId start on it, and a paid plan of the group that ends from the customer portal, a revoked payment authorization or exhausted dunning moves to it instead of canceling. Requires a free plan with a planGroupId; replaces the group's previous default plan.
- `metadata` (`array`, optional)

### Request options

- `idempotencyKey` (`string`, optional) — Unique key used to safely retry this write for 24 hours without applying it twice.

### Returns

`Plan`
