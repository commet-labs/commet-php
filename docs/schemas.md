# Schemas

Generated from Commet API version `2026-08-27`.

## Enums

### BillingInterval

- `"weekly"`
- `"monthly"`
- `"quarterly"`
- `"semiannual"`
- `"yearly"`
- `"one_time"`

### ConsumptionModel

- `"metered"`
- `"credits"`
- `"balance"`

### FeatureType

- `"boolean"`
- `"usage"`
- `"seats"`
- `"quota"`

### InvoiceType

- `"recurring"`
- `"overage"`
- `"plan_change"`
- `"adjustment"`
- `"credit_purchase"`
- `"balance_topup"`
- `"addon_activation"`
- `"one_time_payment"`
- `"reactivation"`
- `"resume"`
- `"prepayment"`

### PaymentMethod

- `"card"`
- `"oxxo"`
- `"mercado_pago"`
- `"google_pay"`
- `"smartpix"`

### PaymentProvider

- `"stripe"`
- `"commet"`
- `"dlocal"`

### SubPaymentMethod

- `"credit_card"`
- `"debit_card"`
- `"prepaid_card"`
- `"bank_transfer"`
- `"account_money"`

### SubscriptionStatus

- `"draft"`
- `"pending_payment"`
- `"trialing"`
- `"active"`
- `"past_due"`
- `"paused"`
- `"canceled"`

### Timezone

- `"UTC"`
- `"America/New_York"`
- `"America/Chicago"`
- `"America/Denver"`
- `"America/Los_Angeles"`
- `"America/Sao_Paulo"`
- `"America/Mexico_City"`
- `"America/Buenos_Aires"`
- `"America/Santiago"`
- `"America/Bogota"`
- `"America/Lima"`
- `"America/Asuncion"`
- `"Europe/London"`
- `"Europe/Paris"`
- `"Europe/Berlin"`
- `"Europe/Madrid"`
- `"Asia/Tokyo"`
- `"Asia/Shanghai"`
- `"Asia/Singapore"`
- `"Asia/Dubai"`
- `"Australia/Sydney"`

### TransactionStatus

- `"pending"`
- `"succeeded"`
- `"failed"`
- `"refunded"`
- `"disputed"`

## Models

### ActiveAddon

- `slug` (`string`, required)
- `name` (`string`, required)
- `basePrice` (`int`, required)
- `featureCode` (`string`, required)
- `featureName` (`string`, required)
- `featureType` (`FeatureType`, required)
- `consumptionModel` (`string`, required)
- `activatedAt` (`string`, required)
- `object` (`string`, required)
- `livemode` (`bool`, required)

### AddedPlanToGroup

- `success` (`bool`, required)
- `object` (`string`, required)
- `livemode` (`bool`, required)

### Addon

- `id` (`string`, required)
- `name` (`string`, required)
- `slug` (`string`, required)
- `description` (`string | null`, required)
- `basePrice` (`int`, required)
- `featureCode` (`string`, required)
- `featureName` (`string`, required)
- `createdAt` (`string`, required)
- `updatedAt` (`string`, required)
- `consumptionModel` (`string`, required)
- `includedUnits` (`int | null`, required)
- `overageRate` (`int | null`, required)
- `creditCost` (`int | null`, required)
- `planIds` (`array`, required) — Plans that sell the add-on.
- `object` (`string`, required)
- `livemode` (`bool`, required)

### AddonsListActiveResult

- `object` (`string`, required)
- `data` (`array`, required)
- `hasMore` (`bool`, required)
- `nextCursor` (`string`, optional)

### AddonsListResult

- `object` (`string`, required)
- `data` (`array`, required)
- `hasMore` (`bool`, required)
- `nextCursor` (`string`, optional)

### AddPlanFeatureParamsOverage

- `enabled` (`bool`, optional)
- `unitPrice` (`int`, optional)

### AddPlanPriceParamsMarketPricesItem

- `marketGroupId` (`string`, required) — Public ID of a reusable pricing market group.
- `currency` (`string`, required) — Presentment currency configured for this plan and market.
- `price` (`int`, required) — Market price in the currency's minor unit.

### ApiKey

- `id` (`string`, required)
- `name` (`string`, required)
- `prefix` (`string`, required)
- `expiresAt` (`string | null`, required)
- `lastUsedAt` (`string | null`, required)
- `createdAt` (`string`, required)
- `object` (`string`, required)
- `livemode` (`bool`, required)

### ApiKeysListResult

- `object` (`string`, required)
- `data` (`array`, required)
- `hasMore` (`bool`, required)
- `nextCursor` (`string`, optional)

### ArchivePlanExperimentParamsChangesItem

- `subscriptionId` (`string`, required)
- `keepOnVersion` (`mixed`, optional) — Leave this subscriber on its version.
- `billingInterval` (`string`, optional)
- `seatLimit` (`mixed`, optional) — Lower its seats to the version's limit at renewal.
- `removeAddonIds` (`array`, optional) — Add-ons it stops paying at renewal.

### BalanceAdjustment

- `amount` (`int`, required)
- `newBalance` (`int`, required)
- `reason` (`string | null`, required)
- `object` (`string`, required)
- `livemode` (`bool`, required)

### BalanceTopup

- `amount` (`int`, required)
- `object` (`string`, required)
- `livemode` (`bool`, required)

### BatchCreateCustomersParamsCustomersItem

- `email` (`string`, required)
- `id` (`string`, optional)
- `externalId` (`string`, optional)
- `fullName` (`string`, optional)
- `taxDocument` (`string`, optional)
- `timezone` (`Timezone`, optional)
- `metadata` (`array`, optional)
- `address` (`BatchCreateCustomersParamsCustomersItemAddress`, optional)

### BatchCreateCustomersParamsCustomersItemAddress

- `line1` (`string`, required)
- `line2` (`string`, optional)
- `city` (`string`, required)
- `state` (`string`, optional)
- `postalCode` (`string`, required)
- `country` (`string`, required)
- `region` (`string`, optional)

### BusinessTaxId

- `country` (`string`, required)
- `type` (`string`, required)
- `value` (`string`, required)

### ClaimLink

- `url` (`string`, required)
- `expiresAt` (`string`, required)
- `object` (`string`, required)
- `livemode` (`bool`, required)

### CreateApiKeyParamsPermissions

- `customer` (`array`, optional)
- `subscription` (`array`, optional)
- `invoice` (`array`, optional)
- `usage` (`array`, optional)
- `seat` (`array`, optional)
- `plan` (`array`, optional)
- `plan_group` (`array`, optional)
- `feature` (`array`, optional)
- `addon` (`array`, optional)
- `credit_pack` (`array`, optional)
- `offer` (`array`, optional)
- `promo_code` (`array`, optional)
- `market_group` (`array`, optional)
- `payment` (`array`, optional)
- `transaction` (`array`, optional)
- `payout` (`array`, optional)
- `test_clock` (`array`, optional)
- `organization` (`array`, optional)
- `api_key` (`array`, optional)

### CreateCustomerParamsAddress

- `line1` (`string`, required)
- `line2` (`string`, optional)
- `city` (`string`, required)
- `state` (`string`, optional)
- `postalCode` (`string`, required)
- `country` (`string`, required)
- `region` (`string`, optional)

### CreatedApiKey

- `id` (`string`, required)
- `name` (`string`, required)
- `apiKey` (`string`, required)
- `prefix` (`string`, required)
- `expiresAt` (`string`, required)
- `createdAt` (`string`, required)
- `object` (`string`, required)
- `livemode` (`bool`, required)

### CreatedSubscription

- `id` (`string`, required)
- `customerId` (`string`, required)
- `plan` (`CreatedSubscriptionPlan`, required)
- `name` (`string`, required)
- `description` (`string | null`, required)
- `status` (`SubscriptionStatus`, required)
- `billingInterval` (`BillingInterval | null`, required)
- `trialEndsAt` (`string | null`, required)
- `currentPeriod` (`CreatedSubscriptionCurrentPeriod | null`, required)
- `cancellation` (`CreatedSubscriptionCancellation | null`, required)
- `cancelAtPeriodEnd` (`bool`, required)
- `scheduledPlanChange` (`CreatedSubscriptionScheduledPlanChange | null`, required)
- `startDate` (`string`, required)
- `endDate` (`string | null`, required)
- `billingDayOfMonth` (`int | null`, required)
- `nextBillingDate` (`string | null`, required)
- `checkoutUrl` (`string | null`, required)
- `hasPaymentMethod` (`bool`, required) — Whether Commet can charge this subscription on its own at its next charge (the trial end or the renewal). A trial that started without a payment method reports false until the customer adds one for this subscription; a payment method saved for another subscription does not count. A subscription on a free plan reports false.
- `createdAt` (`string`, required)
- `updatedAt` (`string`, required)
- `planVersion` (`CreatedSubscriptionPlanVersion | null`, required) — The plan version whose terms the subscription has now. It keeps paying and receiving everything from this version until it is moved.
- `offerApplications` (`array`, required)
- `pause` (`CreatedSubscriptionPause | null`, required)
- `checkoutProvider` (`PaymentProvider | null`, required) — Payment provider resolved for this checkout when the subscription response was created. This is an informational snapshot and may differ when the checkout is loaded if its country or the organization's routing changes.
- `priceId` (`string | null`, required)
- `object` (`string`, required)
- `livemode` (`bool`, required)

### CreatedSubscriptionCancellation

- `scheduledAt` (`string`, required)
- `reason` (`string | null`, required)
- `effectiveAt` (`string`, required)

### CreatedSubscriptionCurrentPeriod

- `start` (`string`, required)
- `end` (`string`, required)
- `daysRemaining` (`float`, required)

### CreatedSubscriptionPause

Variants:

- `CreatedSubscriptionPauseVariant1`
- `CreatedSubscriptionPauseVariant2`

Discriminator: `status`

- `"scheduled"` → `CreatedSubscriptionPauseVariant1`
- `"active"` → `CreatedSubscriptionPauseVariant2`

### CreatedSubscriptionPauseVariant1

- `status` (`string`, required)
- `mode` (`string`, required)
- `requestedAt` (`string`, required)
- `effectiveAt` (`string`, required)
- `resumeAt` (`string | null`, required)

### CreatedSubscriptionPauseVariant2

- `status` (`string`, required)
- `mode` (`string`, required)
- `requestedAt` (`string`, required)
- `effectiveAt` (`string`, required)
- `resumeAt` (`string | null`, required)

### CreatedSubscriptionPlan

- `id` (`string`, required)
- `name` (`string`, required)

### CreatedSubscriptionPlanVersion

- `id` (`string`, required) — Public plan version ID.
- `label` (`string`, required) — Main versions are 1, 2, 3; an experiment's versions carry its own code, like price-test 2.

### CreatedSubscriptionScheduledPlanChange

- `changeType` (`string`, required)
- `newPlanId` (`string | null`, required)
- `newPlanName` (`string | null`, required)
- `newBillingInterval` (`string | null`, required)
- `scheduledFor` (`string`, required)

### CreatedWebhook

- `id` (`string`, required)
- `url` (`string`, required)
- `events` (`array`, required)
- `description` (`string | null`, required)
- `isActive` (`bool`, required)
- `apiVersion` (`string | null`, required)
- `createdAt` (`string`, required)
- `secretKey` (`string`, required)
- `object` (`string`, required)
- `livemode` (`bool`, required)

### CreateOfferParamsPhasesItem

Variants:

- `CreateOfferParamsPhasesItemVariant1`
- `CreateOfferParamsPhasesItemVariant2`
- `CreateOfferParamsPhasesItemVariant3`

Discriminator: `type`

- `"percentage"` → `CreateOfferParamsPhasesItemVariant1`
- `"amount_off"` → `CreateOfferParamsPhasesItemVariant2`
- `"fixed_price"` → `CreateOfferParamsPhasesItemVariant3`

### CreateOfferParamsPhasesItemVariant1

- `type` (`string`, required)
- `durationCycles` (`int | null`, required)
- `durationInterval` (`string | null`, optional) — Unit the phase duration is counted in. Only a fixed-price phase may set it, because its amount is declared rather than derived from the plan. Defaults to the plan's own billing interval.
- `percentage` (`int`, required) — Discount in basis points. 5000 means 50%.

### CreateOfferParamsPhasesItemVariant2

- `type` (`string`, required)
- `durationCycles` (`int | null`, required)
- `durationInterval` (`string | null`, optional) — Unit the phase duration is counted in. Only a fixed-price phase may set it, because its amount is declared rather than derived from the plan. Defaults to the plan's own billing interval.
- `amounts` (`array`, required)

### CreateOfferParamsPhasesItemVariant2AmountsItem

- `currency` (`string`, required)
- `amount` (`int`, required) — Amount in the currency's minor unit (for example, cents for USD).

### CreateOfferParamsPhasesItemVariant3

- `type` (`string`, required)
- `durationCycles` (`int | null`, required)
- `durationInterval` (`string | null`, optional) — Unit the phase duration is counted in. Only a fixed-price phase may set it, because its amount is declared rather than derived from the plan. Defaults to the plan's own billing interval.
- `prices` (`array`, required)

### CreateOfferParamsPhasesItemVariant3PricesItem

- `currency` (`string`, required)
- `amount` (`int`, required) — Amount in the currency's minor unit (for example, cents for USD).

### CreatePlanExperimentParamsCurrenciesItem

- `currency` (`string`, required)
- `exchangeRate` (`float`, required)

### CreatePlanExperimentParamsPricesItem

- `billingInterval` (`string`, required) — An interval the plan already sells. Prices not listed are copied unchanged from the current version.
- `price` (`int`, required) — USD price in the currency's minor unit (cents).
- `includedCredits` (`int | null`, optional)
- `includedBalance` (`int | null`, optional)
- `regionalPrices` (`array`, optional) — Per-currency amounts. A currency the current version does not sell also needs its exchangeRate in currencies; its amounts not listed here are derived from the USD price.

### CreatePlanExperimentParamsPricesItemRegionalPricesItem

- `currency` (`string`, required)
- `price` (`int`, required)
- `includedBalance` (`int | null`, optional)

### CreatePlanExperimentVersionParamsCurrenciesItem

- `currency` (`string`, required)
- `exchangeRate` (`float`, required)

### CreatePlanExperimentVersionParamsPricesItem

- `billingInterval` (`string`, required) — An interval the plan already sells. Prices not listed are copied unchanged from the current version.
- `price` (`int`, required) — USD price in the currency's minor unit (cents).
- `includedCredits` (`int | null`, optional)
- `includedBalance` (`int | null`, optional)
- `regionalPrices` (`array`, optional) — Per-currency amounts. A currency the current version does not sell also needs its exchangeRate in currencies; its amounts not listed here are derived from the USD price.

### CreatePlanExperimentVersionParamsPricesItemRegionalPricesItem

- `currency` (`string`, required)
- `price` (`int`, required)
- `includedBalance` (`int | null`, optional)

### CreatePlanMoveParamsChangesItem

- `subscriptionId` (`string`, required)
- `keepOnVersion` (`mixed`, optional) — Leave this subscriber on its version.
- `billingInterval` (`string`, optional)
- `seatLimit` (`mixed`, optional) — Lower its seats to the version's limit at renewal.
- `removeAddonIds` (`array`, optional) — Add-ons it stops paying at renewal.

### CreatePlanParamsPlanBalanceLimit

- `amount` (`int`, required) — The most plan balance a subscription spends in one window, in USD cents. Other currencies convert it with the plan's exchange rate unless the dashboard sets a custom amount for that currency.
- `interval` (`string`, required) — The window length: `day` is 24 hours and `week` is 7 days, starting at the time of day of the subscription's billing anchor.

### CreatePlanParamsPlanCreditLimit

- `credits` (`int`, required) — The most plan credits a subscription spends in one window.
- `interval` (`string`, required) — The window length: `day` is 24 hours and `week` is 7 days, starting at the time of day of the subscription's billing anchor.

### CreatePlanParamsUnusedPlanBalance

Variants:

- `CreatePlanParamsUnusedPlanBalanceVariant1`
- `CreatePlanParamsUnusedPlanBalanceVariant2`

Discriminator: `type`

- `"expire"` → `CreatePlanParamsUnusedPlanBalanceVariant1`
- `"roll_over"` → `CreatePlanParamsUnusedPlanBalanceVariant2`

### CreatePlanParamsUnusedPlanBalanceVariant1

- `type` (`string`, required)

### CreatePlanParamsUnusedPlanBalanceVariant2

- `type` (`string`, required)
- `maxPlanBalance` (`int | null`, required) — The most plan balance a subscription holds after a reset, in USD cents, including the balance that reset grants; balance above it expires. At least the included balance of every price. Other currencies convert it with the plan's exchange rate unless the dashboard sets a custom amount for that currency. null means no limit other than the largest storable amount, 2,147,483,647 cents.

### CreatePlanParamsUnusedPlanCredits

Variants:

- `CreatePlanParamsUnusedPlanCreditsVariant1`
- `CreatePlanParamsUnusedPlanCreditsVariant2`

Discriminator: `type`

- `"expire"` → `CreatePlanParamsUnusedPlanCreditsVariant1`
- `"roll_over"` → `CreatePlanParamsUnusedPlanCreditsVariant2`

### CreatePlanParamsUnusedPlanCreditsVariant1

- `type` (`string`, required)

### CreatePlanParamsUnusedPlanCreditsVariant2

- `type` (`string`, required)
- `maxPlanCredits` (`int | null`, required) — The most plan credits a subscription holds after a reset, including the credits that reset grants; credits above it expire. At least the included credits of every price. null means no limit other than the largest storable balance, 2,147,483,647 plan credits.

### CreatePlanVersionParamsCurrenciesItem

- `currency` (`string`, required)
- `exchangeRate` (`float`, required)

### CreatePlanVersionParamsPricesItem

- `billingInterval` (`string`, required) — An interval the plan already sells. Prices not listed are copied unchanged from the current version.
- `price` (`int`, required) — USD price in the currency's minor unit (cents).
- `includedCredits` (`int | null`, optional)
- `includedBalance` (`int | null`, optional)
- `regionalPrices` (`array`, optional) — Per-currency amounts. A currency the current version does not sell also needs its exchangeRate in currencies; its amounts not listed here are derived from the USD price.

### CreatePlanVersionParamsPricesItemRegionalPricesItem

- `currency` (`string`, required)
- `price` (`int`, required)
- `includedBalance` (`int | null`, optional)

### CreditGrant

- `credits` (`int`, required)
- `object` (`string`, required)
- `livemode` (`bool`, required)

### CreditPack

- `id` (`string`, required)
- `name` (`string`, required)
- `description` (`string | null`, required)
- `credits` (`int`, required)
- `price` (`int`, required)
- `planIds` (`array`, required) — Plans that sell the credit pack.
- `isActive` (`bool`, required)
- `createdAt` (`string`, required)
- `updatedAt` (`string`, required)
- `object` (`string`, required)
- `livemode` (`bool`, required)

### CreditPackListItem

- `id` (`string`, required)
- `name` (`string`, required)
- `description` (`string | null`, required)
- `credits` (`int`, required)
- `price` (`int`, required)
- `planIds` (`array`, required) — Plans that sell the credit pack.
- `currency` (`string`, required)
- `object` (`string`, required)
- `livemode` (`bool`, required)

### CreditPacksListResult

- `object` (`string`, required)
- `data` (`array`, required)
- `hasMore` (`bool`, required)
- `nextCursor` (`string`, optional)

### Customer

- `id` (`string`, required)
- `externalId` (`string | null`, required)
- `fullName` (`string | null`, required)
- `email` (`string`, required)
- `taxDocument` (`string | null`, required)
- `documentType` (`string | null`, required)
- `businessTaxId` (`BusinessTaxId | null`, required)
- `timezone` (`string | null`, required)
- `metadata` (`array | null`, required)
- `createdAt` (`string`, required)
- `updatedAt` (`string`, required)
- `object` (`string`, required)
- `livemode` (`bool`, required)

### CustomerBatch

- `successful` (`array`, required)
- `failed` (`array`, required)
- `object` (`string`, required)
- `livemode` (`bool`, required)

### CustomerBatchFailedItem

- `index` (`int`, required)
- `error` (`string`, required)
- `data` (`CustomerBatchFailedItemData`, required)

### CustomerBatchFailedItemData

- `id` (`string`, optional)
- `externalId` (`string`, optional)
- `email` (`string`, required)
- `fullName` (`string | null`, optional)
- `taxDocument` (`string | null`, optional)
- `timezone` (`string`, optional)
- `metadata` (`array | null`, optional)
- `address` (`CustomerBatchFailedItemDataAddress`, optional)

### CustomerBatchFailedItemDataAddress

- `line1` (`string`, required)
- `line2` (`string`, optional)
- `city` (`string`, required)
- `state` (`string`, optional)
- `postalCode` (`string`, required)
- `country` (`string`, required)
- `region` (`string`, optional)

### CustomerBatchSuccessfulItem

- `id` (`string`, required)
- `externalId` (`string | null`, required)
- `email` (`string`, required)

### CustomerCredit

- `id` (`string`, required)
- `amount` (`int`, required) — Original grant amount in the currency's smallest unit.
- `appliedAmount` (`int`, required)
- `reversedAmount` (`int`, required)
- `revokedAmount` (`int`, required)
- `remainingAmount` (`int`, required)
- `currency` (`string`, required)
- `reason` (`string`, required)
- `source` (`string`, required)
- `expiresAt` (`string | null`, required)
- `createdAt` (`string`, required)
- `object` (`string`, required)
- `livemode` (`bool`, required)

### CustomerCreditRevocation

- `id` (`string`, required)
- `remainingAmount` (`int`, required)
- `revokedAmount` (`int`, required)
- `currency` (`string`, required)
- `object` (`string`, required)
- `livemode` (`bool`, required)

### CustomersListCreditsResult

- `object` (`string`, required)
- `data` (`array`, required)
- `hasMore` (`bool`, required)
- `nextCursor` (`string`, optional)

### CustomersListPlanGrantsResult

- `object` (`string`, required)
- `data` (`array`, required)
- `hasMore` (`bool`, required)
- `nextCursor` (`string`, optional)

### CustomersListResult

- `object` (`string`, required)
- `data` (`array`, required)
- `hasMore` (`bool`, required)
- `nextCursor` (`string`, optional)

### DeletedObject

- `id` (`string`, required)
- `deleted` (`mixed`, required)
- `object` (`string`, required)
- `livemode` (`bool`, required)

### DeletedOffer

- `deleted` (`mixed`, required)
- `object` (`string`, required)
- `livemode` (`bool`, required)

### DeletedPlanRegionalPricing

- `deleted` (`mixed`, required)
- `object` (`string`, required)
- `livemode` (`bool`, required)

### DeletedSubscriptionAddon

- `id` (`string`, required)
- `status` (`string`, required)
- `deactivatedAt` (`string | null`, required)
- `object` (`string`, required)
- `livemode` (`bool`, required)

### Feature

- `id` (`string`, required)
- `name` (`string`, required)
- `code` (`string`, required)
- `type` (`FeatureType`, required)
- `description` (`string | null`, required)
- `unitName` (`string | null`, required)
- `createdAt` (`string`, required)
- `updatedAt` (`string`, required)
- `object` (`string`, required)
- `livemode` (`bool`, required)

### FeatureAccess

Variants:

- `FeatureAccessVariant1`
- `FeatureAccessVariant2`
- `FeatureAccessVariant3`
- `FeatureAccessVariant4`

Discriminator: `type`

- `"boolean"` → `FeatureAccessVariant1`
- `"usage"` → `FeatureAccessVariant2`
- `"seats"` → `FeatureAccessVariant3`
- `"quota"` → `FeatureAccessVariant4`

### FeatureAccessListResult

- `object` (`string`, required)
- `data` (`array`, required)
- `hasMore` (`bool`, required)
- `nextCursor` (`string`, optional)

### FeatureAccessVariant1

- `code` (`string`, required) — Unique feature code.
- `name` (`string`, required) — Display name of the feature.
- `unitName` (`string | null`, required) — Display name for one product unit, or null when not applicable.
- `allowed` (`bool`, required) — Whether the customer can currently access or consume the feature.
- `type` (`string`, required)
- `enabled` (`bool`, required) — Whether the feature is enabled.
- `baseAccess` (`FeatureAccessVariant1BaseAccess | null`, optional)
- `object` (`string`, required)
- `livemode` (`bool`, required)

### FeatureAccessVariant1BaseAccess

- `enabled` (`bool`, required)

### FeatureAccessVariant2

- `code` (`string`, required) — Unique feature code.
- `name` (`string`, required) — Display name of the feature.
- `unitName` (`string | null`, required) — Display name for one product unit, or null when not applicable.
- `allowed` (`bool`, required) — Whether the customer can currently access or consume the feature.
- `type` (`string`, required)
- `consumption` (`FeatureAccessVariant2Consumption`, required)
- `baseAccess` (`FeatureAccessVariant2BaseAccess | null`, optional)
- `object` (`string`, required)
- `livemode` (`bool`, required)

### FeatureAccessVariant2BaseAccess

- `includedUnits` (`float`, required)
- `unlimited` (`bool`, required)

### FeatureAccessVariant2Consumption

Variants:

- `FeatureAccessVariant2ConsumptionVariant1`
- `FeatureAccessVariant2ConsumptionVariant2`
- `FeatureAccessVariant2ConsumptionVariant3`

Discriminator: `model`

- `"metered"` → `FeatureAccessVariant2ConsumptionVariant1`
- `"credits"` → `FeatureAccessVariant2ConsumptionVariant2`
- `"balance"` → `FeatureAccessVariant2ConsumptionVariant3`

### FeatureAccessVariant2ConsumptionVariant1

- `model` (`string`, required) — Usage is measured against an included allowance and overage.
- `period` (`FeatureAccessVariant2ConsumptionVariant1Period`, required) — Time range used to calculate this feature's consumption.
- `unitsUsed` (`float`, required) — Product units recorded during the period.
- `includedUnits` (`float`, required) — Product units included in the subscription for the period.
- `remainingUnits` (`float`, optional) — Included units not yet consumed. Absent when usage is unlimited.
- `unlimited` (`bool`, required) — Whether the feature has no usage limit.
- `overage` (`FeatureAccessVariant2ConsumptionVariant1Overage`, required)

### FeatureAccessVariant2ConsumptionVariant1Overage

- `enabled` (`bool`, required) — Whether usage above the included amount is allowed and billed.
- `units` (`float`, required) — Units consumed above the included amount.
- `unitPrice` (`FeatureAccessVariant2ConsumptionVariant1OverageUnitPrice`, optional) — Price for one additional product unit.

### FeatureAccessVariant2ConsumptionVariant1OverageUnitPrice

- `amount` (`int`, required) — Integer rate amount. Divide by scale to obtain the price.
- `currency` (`string`, required) — Lowercase ISO 4217 currency code.
- `scale` (`mixed`, required) — Divide amount by scale to obtain the major-unit price.

### FeatureAccessVariant2ConsumptionVariant1Period

- `start` (`string`, required) — Inclusive usage period start.
- `end` (`string`, required) — Exclusive usage period end.

### FeatureAccessVariant2ConsumptionVariant2

- `model` (`string`, required) — Product usage consumes credits from a shared pool.
- `period` (`FeatureAccessVariant2ConsumptionVariant2Period`, required) — Time range used to calculate this feature's consumption.
- `unitsUsed` (`float`, required) — Product units recorded during the period.
- `creditsPerUnit` (`int`, required) — Credits deducted for each product unit.
- `creditsConsumed` (`float`, required) — Actual credits deducted by this feature during the period.
- `availableUnits` (`int`, required) — Additional product units available from the current shared credit pool at this feature's conversion rate.

### FeatureAccessVariant2ConsumptionVariant2Period

- `start` (`string`, required) — Inclusive usage period start.
- `end` (`string`, required) — Exclusive usage period end.

### FeatureAccessVariant2ConsumptionVariant3

- `model` (`string`, required) — Product usage deducts money from a shared balance.
- `period` (`FeatureAccessVariant2ConsumptionVariant3Period`, required) — Time range used to calculate this feature's consumption.
- `unitsUsed` (`float`, required) — Product units recorded during the period.
- `spent` (`FeatureAccessVariant2ConsumptionVariant3Spent`, required) — Actual money deducted for this feature during the period.
- `availableUnits` (`int`, optional) — Estimated additional units available from the current shared balance at this feature's fixed price. Absent for dynamic pricing.
- `unitPrice` (`FeatureAccessVariant2ConsumptionVariant3UnitPrice`, optional) — Price for one additional product unit.

### FeatureAccessVariant2ConsumptionVariant3Period

- `start` (`string`, required) — Inclusive usage period start.
- `end` (`string`, required) — Exclusive usage period end.

### FeatureAccessVariant2ConsumptionVariant3Spent

- `amount` (`int`, required) — Amount in the currency's smallest unit.
- `currency` (`string`, required) — Lowercase ISO 4217 currency code.

### FeatureAccessVariant2ConsumptionVariant3UnitPrice

- `amount` (`int`, required) — Integer rate amount. Divide by scale to obtain the price.
- `currency` (`string`, required) — Lowercase ISO 4217 currency code.
- `scale` (`mixed`, required) — Divide amount by scale to obtain the major-unit price.

### FeatureAccessVariant3

- `code` (`string`, required) — Unique feature code.
- `name` (`string`, required) — Display name of the feature.
- `unitName` (`string | null`, required) — Display name for one product unit, or null when not applicable.
- `allowed` (`bool`, required) — Whether the customer can currently access or consume the feature.
- `type` (`string`, required)
- `usage` (`FeatureAccessVariant3Usage`, required)
- `baseAccess` (`FeatureAccessVariant3BaseAccess | null`, optional)
- `object` (`string`, required)
- `livemode` (`bool`, required)

### FeatureAccessVariant3BaseAccess

- `includedUnits` (`float`, required)
- `unlimited` (`bool`, required)

### FeatureAccessVariant3Usage

- `period` (`FeatureAccessVariant3UsagePeriod`, required) — Time range used to calculate this feature's consumption.
- `unitsUsed` (`float`, required) — Current units assigned or in use.
- `includedUnits` (`float`, required) — Units included in the subscription for the period.
- `remainingUnits` (`float`, optional) — Included units still available. Absent when usage is unlimited.
- `unlimited` (`bool`, required) — Whether the feature has no usage limit.
- `overage` (`FeatureAccessVariant3UsageOverage`, required)

### FeatureAccessVariant3UsageOverage

- `enabled` (`bool`, required) — Whether usage above the included amount is allowed and billed.
- `units` (`float`, required) — Units consumed above the included amount.
- `unitPrice` (`FeatureAccessVariant3UsageOverageUnitPrice`, optional) — Price for one additional product unit.

### FeatureAccessVariant3UsageOverageUnitPrice

- `amount` (`int`, required) — Integer rate amount. Divide by scale to obtain the price.
- `currency` (`string`, required) — Lowercase ISO 4217 currency code.
- `scale` (`mixed`, required) — Divide amount by scale to obtain the major-unit price.

### FeatureAccessVariant3UsagePeriod

- `start` (`string`, required) — Inclusive usage period start.
- `end` (`string`, required) — Exclusive usage period end.

### FeatureAccessVariant4

- `code` (`string`, required) — Unique feature code.
- `name` (`string`, required) — Display name of the feature.
- `unitName` (`string | null`, required) — Display name for one product unit, or null when not applicable.
- `allowed` (`bool`, required) — Whether the customer can currently access or consume the feature.
- `type` (`string`, required)
- `usage` (`FeatureAccessVariant4Usage`, required)
- `baseAccess` (`FeatureAccessVariant4BaseAccess | null`, optional)
- `object` (`string`, required)
- `livemode` (`bool`, required)

### FeatureAccessVariant4BaseAccess

- `includedUnits` (`float`, required)
- `unlimited` (`bool`, required)

### FeatureAccessVariant4Usage

- `period` (`FeatureAccessVariant4UsagePeriod`, required) — Time range used to calculate this feature's consumption.
- `unitsUsed` (`float`, required) — Current units assigned or in use.
- `includedUnits` (`float`, required) — Units included in the subscription for the period.
- `remainingUnits` (`float`, optional) — Included units still available. Absent when usage is unlimited.
- `unlimited` (`bool`, required) — Whether the feature has no usage limit.
- `overage` (`FeatureAccessVariant4UsageOverage`, required)
- `billedUnits` (`float`, required) — Highest quota reached during the period and used for billing.

### FeatureAccessVariant4UsageOverage

- `enabled` (`bool`, required) — Whether usage above the included amount is allowed and billed.
- `units` (`float`, required) — Units consumed above the included amount.
- `unitPrice` (`FeatureAccessVariant4UsageOverageUnitPrice`, optional) — Price for one additional product unit.

### FeatureAccessVariant4UsageOverageUnitPrice

- `amount` (`int`, required) — Integer rate amount. Divide by scale to obtain the price.
- `currency` (`string`, required) — Lowercase ISO 4217 currency code.
- `scale` (`mixed`, required) — Divide amount by scale to obtain the major-unit price.

### FeatureAccessVariant4UsagePeriod

- `start` (`string`, required) — Inclusive usage period start.
- `end` (`string`, required) — Exclusive usage period end.

### FeaturesListResult

- `object` (`string`, required)
- `data` (`array`, required)
- `hasMore` (`bool`, required)
- `nextCursor` (`string`, optional)

### Invoice

- `id` (`string`, required)
- `customerId` (`string`, required)
- `subscriptionId` (`string | null`, required)
- `invoiceNumber` (`string`, required)
- `status` (`string`, required)
- `invoiceType` (`InvoiceType`, required)
- `currency` (`string`, required)
- `subtotal` (`int`, required)
- `discountAmount` (`int`, required)
- `taxAmount` (`int`, required)
- `total` (`int`, required)
- `periodStart` (`string`, required)
- `periodEnd` (`string`, required)
- `issueDate` (`string`, required)
- `dueDate` (`string`, required)
- `memo` (`string | null`, required)
- `metadata` (`array`, required)
- `createdAt` (`string`, required)
- `updatedAt` (`string`, required)
- `creditApplied` (`int`, required)
- `planName` (`string | null`, required)
- `poNumber` (`string | null`, required)
- `reference` (`string | null`, required)
- `lineItems` (`array`, required)
- `object` (`string`, required)
- `livemode` (`bool`, required)

### InvoiceDownload

- `url` (`string`, required)
- `expiresAt` (`string`, required)
- `object` (`string`, required)
- `livemode` (`bool`, required)

### InvoiceLineItemsItem

- `lineType` (`string`, required)
- `featureName` (`string | null`, required)
- `description` (`string`, required)
- `quantity` (`int`, required)
- `unitAmount` (`int`, required)
- `amount` (`int`, required)
- `includedAmount` (`int | null`, required)
- `usedAmount` (`int | null`, required)
- `overageAmount` (`int | null`, required)
- `discountType` (`string | null`, required)
- `discountValue` (`int | null`, required)
- `discountName` (`string | null`, required)
- `chargeType` (`string`, required)

### InvoiceListItem

- `id` (`string`, required)
- `customerId` (`string`, required)
- `subscriptionId` (`string | null`, required)
- `invoiceNumber` (`string`, required)
- `status` (`string`, required)
- `invoiceType` (`InvoiceType`, required)
- `currency` (`string`, required)
- `subtotal` (`int`, required)
- `discountAmount` (`int`, required)
- `taxAmount` (`int`, required)
- `total` (`int`, required)
- `periodStart` (`string`, required)
- `periodEnd` (`string`, required)
- `issueDate` (`string`, required)
- `dueDate` (`string`, required)
- `memo` (`string | null`, required)
- `metadata` (`array`, required)
- `createdAt` (`string`, required)
- `updatedAt` (`string`, required)
- `object` (`string`, required)
- `livemode` (`bool`, required)

### InvoicesListResult

- `object` (`string`, required)
- `data` (`array`, required)
- `hasMore` (`bool`, required)
- `nextCursor` (`string`, optional)

### KeptOnVersion

- `subscriptionId` (`string`, required)
- `keptOnVersion` (`mixed`, required)
- `object` (`string`, required)
- `livemode` (`bool`, required)

### ManagedBy

Variants:

- `string`
- `null`

### Market

- `id` (`string`, required)
- `name` (`string`, required)
- `countryCodes` (`array`, required)
- `metadata` (`array`, required)
- `createdAt` (`string`, required)
- `updatedAt` (`string`, required)
- `object` (`string`, required)
- `livemode` (`bool`, required)

### MarketsListResult

- `object` (`string`, required)
- `data` (`array`, required)
- `hasMore` (`bool`, required)
- `nextCursor` (`string`, optional)

### Offer

- `id` (`string`, required)
- `name` (`string`, required)
- `phases` (`array`, required)
- `metadata` (`array`, required)
- `startsAt` (`string | null`, required)
- `endsAt` (`string | null`, required)
- `active` (`bool`, required)
- `managedBy` (`ManagedBy`, required) — Integration that manages this record, or null when the merchant does. While an integration manages it, its terms change only in that integration and edits answer 409 managed_by_integration.
- `createdAt` (`string`, required)
- `updatedAt` (`string`, required)
- `object` (`string`, required)
- `livemode` (`bool`, required)

### OfferPhasesItem

Variants:

- `OfferPhasesItemVariant1`
- `OfferPhasesItemVariant2`
- `OfferPhasesItemVariant3`

Discriminator: `type`

- `"percentage"` → `OfferPhasesItemVariant1`
- `"amount_off"` → `OfferPhasesItemVariant2`
- `"fixed_price"` → `OfferPhasesItemVariant3`

### OfferPhasesItemVariant1

- `type` (`string`, required)
- `durationCycles` (`int | null`, required)
- `durationInterval` (`string | null`, required) — Unit the phase duration is counted in. Only a fixed-price phase may set it, because its amount is declared rather than derived from the plan. Defaults to the plan's own billing interval.
- `percentage` (`int`, required) — Discount in basis points. 5000 means 50%.

### OfferPhasesItemVariant2

- `type` (`string`, required)
- `durationCycles` (`int | null`, required)
- `durationInterval` (`string | null`, required) — Unit the phase duration is counted in. Only a fixed-price phase may set it, because its amount is declared rather than derived from the plan. Defaults to the plan's own billing interval.
- `amounts` (`array`, required)

### OfferPhasesItemVariant2AmountsItem

- `currency` (`string`, required)
- `amount` (`int`, required) — Amount in the currency's minor unit (for example, cents for USD).

### OfferPhasesItemVariant3

- `type` (`string`, required)
- `durationCycles` (`int | null`, required)
- `durationInterval` (`string | null`, required) — Unit the phase duration is counted in. Only a fixed-price phase may set it, because its amount is declared rather than derived from the plan. Defaults to the plan's own billing interval.
- `prices` (`array`, required)

### OfferPhasesItemVariant3PricesItem

- `currency` (`string`, required)
- `amount` (`int`, required) — Amount in the currency's minor unit (for example, cents for USD).

### OffersListResult

- `object` (`string`, required)
- `data` (`array`, required)
- `hasMore` (`bool`, required)
- `nextCursor` (`string`, optional)

### Payment

- `paymentContext` (`PaymentPaymentContext | null`, required) — Charge context captured for new payments. Null for historical payments with no captured context.
- `id` (`string`, required)
- `customerId` (`string | null`, required)
- `kind` (`string`, required)
- `status` (`string`, required)
- `provider` (`string`, required)
- `amountSubtotal` (`int`, required)
- `taxAmount` (`int`, required)
- `amountTotal` (`int`, required)
- `currency` (`string`, required)
- `description` (`string`, required)
- `metadata` (`array | null`, required)
- `url` (`string | null`, required)
- `expiresAt` (`string | null`, required)
- `createdAt` (`string`, required)
- `updatedAt` (`string`, required)
- `object` (`string`, required)
- `livemode` (`bool`, required)

### PaymentMethodUpdateCheckout

- `checkoutUrl` (`string`, required)
- `object` (`string`, required)
- `livemode` (`bool`, required)

### PaymentPaymentContext

- `reason` (`string`, required) — The original reason for the charge. Recovery never replaces this reason.
- `paymentLinkId` (`string | null`, required) — The public payment link ID, independently of the reason, or null when no payment link originated the charge.
- `recovery` (`PaymentPaymentContextRecovery | null`, required)

### PaymentPaymentContextRecovery

Variants:

- `PaymentPaymentContextRecoveryVariant1`
- `PaymentPaymentContextRecoveryVariant2`

Discriminator: `type`

- `"payment_recovery"` → `PaymentPaymentContextRecoveryVariant1`
- `"dunning_retry"` → `PaymentPaymentContextRecoveryVariant2`

### PaymentPaymentContextRecoveryVariant1

- `type` (`string`, required)

### PaymentPaymentContextRecoveryVariant2

- `type` (`string`, required)
- `attempt` (`int`, required) — Current retry, starting at 1. The original decline is not a retry.
- `maxAttempts` (`int`, required) — Total retries applicable to this charge's dunning schedule.

### PaymentsListResult

- `object` (`string`, required)
- `data` (`array`, required)
- `hasMore` (`bool`, required)
- `nextCursor` (`string`, optional)

### Payout

- `id` (`string`, required)
- `status` (`string`, required)
- `amount` (`int`, required)
- `fee` (`int`, required)
- `netAmount` (`int`, required)
- `currency` (`string`, required)
- `description` (`string | null`, required)
- `providerTransferId` (`string`, required)
- `createdAt` (`string`, required)
- `object` (`string`, required)
- `livemode` (`bool`, required)

### PayoutBankAccount

- `id` (`string`, required)
- `providerExternalAccountId` (`string | null`, required)
- `holderName` (`string`, required)
- `last4` (`string`, required)
- `bankName` (`string | null`, required)
- `country` (`string`, required)
- `currency` (`string`, required)
- `accountType` (`string | null`, required)
- `isDefault` (`bool`, required)
- `status` (`string`, required)
- `createdAt` (`string`, required)
- `object` (`string`, required)
- `livemode` (`bool`, required)

### Plan

- `id` (`string`, required)
- `name` (`string`, required)
- `code` (`string`, required)
- `description` (`string | null`, required)
- `consumptionModel` (`ConsumptionModel | null`, required)
- `isPublic` (`bool`, required)
- `isDefault` (`bool`, required)
- `isFree` (`bool`, required)
- `blockOnExhaustion` (`bool | null`, required) — Credits and balance plans: true stops usage when the plan and purchased amounts run out; false lets usage continue and bills the missing amount as overage at the next renewal (credits at the price per credit). Trials and free plans always stop.
- `unusedPlanCredits` (`PlanUnusedPlanCredits | null`, required) — Credits plans only; null for other consumption models. What happens to unused plan credits at each reset. Purchased credits never expire and never count toward maxPlanCredits.
- `planCreditLimit` (`PlanPlanCreditLimit | null`, required) — Credits plans only. The most plan credits a subscription spends per day or per week; null means no limit.
- `unusedPlanBalance` (`PlanUnusedPlanBalance | null`, required) — Balance plans only; null for other consumption models. What happens to unused plan balance at each reset. Purchased balance never expires and never counts toward maxPlanBalance.
- `planBalanceLimit` (`PlanPlanBalanceLimit | null`, required) — Balance plans only. The most plan balance a subscription spends per day or per week, in USD cents; null means no limit.
- `sortOrder` (`int`, required)
- `planGroupId` (`string | null`, required)
- `metadata` (`array | null`, required)
- `createdAt` (`string`, required)
- `updatedAt` (`string`, required)
- `features` (`array`, required)
- `prices` (`array`, required)
- `exchangeRates` (`array`, required)
- `countries` (`array`, required) — Countries with their own currency or prices in the current version. Buyers from any other country pay the USD prices.
- `object` (`string`, required)
- `livemode` (`bool`, required)

### PlanChange

Variants:

- `PlanChangeVariant1`
- `PlanChangeVariant2`
- `PlanChangeVariant3`

Discriminator: `outcome`

- `"requires_checkout"` → `PlanChangeVariant1`
- `"scheduled"` → `PlanChangeVariant2`
- `"completed"` → `PlanChangeVariant3`

### PlanChangeVariant1

- `outcome` (`string`, required)
- `requiresCheckout` (`mixed`, required)
- `checkoutUrl` (`string`, required)
- `offerApplication` (`PlanChangeVariant1OfferApplication`, optional)
- `object` (`string`, required)
- `livemode` (`bool`, required)

### PlanChangeVariant1OfferApplication

- `id` (`string`, required)
- `offerId` (`string`, required)
- `name` (`string`, required)
- `currency` (`string`, required)
- `subtotal` (`int`, required) — Subtotal in the currency's minor unit.
- `discountAmount` (`int`, required) — Discount in the currency's minor unit.
- `total` (`int`, required) — Total in the currency's minor unit.
- `phases` (`array`, required)
- `appliesTo` (`PlanChangeVariant1OfferApplicationAppliesTo`, required)

### PlanChangeVariant1OfferApplicationAppliesTo

Variants:

- `PlanChangeVariant1OfferApplicationAppliesToVariant1`
- `PlanChangeVariant1OfferApplicationAppliesToVariant2`
- `PlanChangeVariant1OfferApplicationAppliesToVariant3`

Discriminator: `type`

- `"plan_price"` → `PlanChangeVariant1OfferApplicationAppliesToVariant1`
- `"addon"` → `PlanChangeVariant1OfferApplicationAppliesToVariant2`
- `"credit_pack"` → `PlanChangeVariant1OfferApplicationAppliesToVariant3`

### PlanChangeVariant1OfferApplicationAppliesToVariant1

- `type` (`string`, required)
- `id` (`string`, required)

### PlanChangeVariant1OfferApplicationAppliesToVariant2

- `type` (`string`, required)
- `id` (`string`, required)

### PlanChangeVariant1OfferApplicationAppliesToVariant3

- `type` (`string`, required)
- `id` (`string`, required)

### PlanChangeVariant1OfferApplicationPhasesItem

Variants:

- `PlanChangeVariant1OfferApplicationPhasesItemVariant1`
- `PlanChangeVariant1OfferApplicationPhasesItemVariant2`
- `PlanChangeVariant1OfferApplicationPhasesItemVariant3`
- `PlanChangeVariant1OfferApplicationPhasesItemVariant4`

Discriminator: `type`

- `"free_trial"` → `PlanChangeVariant1OfferApplicationPhasesItemVariant1`
- `"percentage"` → `PlanChangeVariant1OfferApplicationPhasesItemVariant2`
- `"amount_off"` → `PlanChangeVariant1OfferApplicationPhasesItemVariant3`
- `"fixed_price"` → `PlanChangeVariant1OfferApplicationPhasesItemVariant4`

### PlanChangeVariant1OfferApplicationPhasesItemVariant1

- `type` (`string`, required)
- `durationDays` (`int`, required)
- `startsAt` (`string | null`, required)
- `endsAt` (`string | null`, required)

### PlanChangeVariant1OfferApplicationPhasesItemVariant2

- `type` (`string`, required)
- `durationCycles` (`int | null`, required)
- `durationInterval` (`string | null`, required)
- `startsAt` (`string | null`, required)
- `endsAt` (`string | null`, required)
- `percentage` (`int`, required) — Discount in basis points. 5000 means 50%.

### PlanChangeVariant1OfferApplicationPhasesItemVariant3

- `type` (`string`, required)
- `durationCycles` (`int | null`, required)
- `durationInterval` (`string | null`, required)
- `startsAt` (`string | null`, required)
- `endsAt` (`string | null`, required)
- `amount` (`int`, required) — Discount in the application currency's minor unit.

### PlanChangeVariant1OfferApplicationPhasesItemVariant4

- `type` (`string`, required)
- `durationCycles` (`int | null`, required)
- `durationInterval` (`string | null`, required)
- `startsAt` (`string | null`, required)
- `endsAt` (`string | null`, required)
- `price` (`int`, required) — Fixed price in the application currency's minor unit.

### PlanChangeVariant2

- `outcome` (`string`, required)
- `id` (`string`, required)
- `scheduled` (`mixed`, required)
- `scheduledFor` (`string`, required)
- `changeType` (`string`, required)
- `customerId` (`string`, required)
- `newPlanId` (`string`, optional)
- `newPlanName` (`string`, optional)
- `newBillingInterval` (`string`, optional)
- `seatLimitWarning` (`PlanChangeVariant2SeatLimitWarning`, optional)
- `object` (`string`, required)
- `livemode` (`bool`, required)

### PlanChangeVariant2SeatLimitWarning

- `featureCode` (`string`, required)
- `featureName` (`string`, required)
- `currentSeats` (`int`, required)
- `included` (`int`, required)
- `newPlanName` (`string`, required)
- `effectiveDate` (`string`, required)

### PlanChangeVariant3

- `outcome` (`string`, required)
- `id` (`string`, required)
- `scheduled` (`mixed`, required)
- `customerId` (`string`, required)
- `previousPlan` (`PlanChangeVariant3PreviousPlan`, required)
- `currentPlan` (`PlanChangeVariant3CurrentPlan`, required)
- `billingInterval` (`string`, required)
- `billing` (`PlanChangeVariant3Billing`, required)
- `invoiceId` (`string`, optional)
- `offerApplication` (`PlanChangeVariant3OfferApplication`, optional)
- `object` (`string`, required)
- `livemode` (`bool`, required)

### PlanChangeVariant3Billing

- `credit` (`int`, required)
- `creditsApplied` (`int`, required)
- `charge` (`int`, required)
- `taxAmount` (`int`, required)
- `netAmount` (`int`, required)
- `totalCharged` (`int`, required)
- `remainingCreditBalance` (`int`, required)

### PlanChangeVariant3CurrentPlan

- `id` (`string`, required)
- `name` (`string`, required)
- `price` (`int`, required)

### PlanChangeVariant3OfferApplication

- `id` (`string`, required)
- `offerId` (`string`, required)
- `name` (`string`, required)
- `currency` (`string`, required)
- `subtotal` (`int`, required) — Subtotal in the currency's minor unit.
- `discountAmount` (`int`, required) — Discount in the currency's minor unit.
- `total` (`int`, required) — Total in the currency's minor unit.
- `phases` (`array`, required)
- `appliesTo` (`PlanChangeVariant3OfferApplicationAppliesTo`, required)

### PlanChangeVariant3OfferApplicationAppliesTo

Variants:

- `PlanChangeVariant3OfferApplicationAppliesToVariant1`
- `PlanChangeVariant3OfferApplicationAppliesToVariant2`
- `PlanChangeVariant3OfferApplicationAppliesToVariant3`

Discriminator: `type`

- `"plan_price"` → `PlanChangeVariant3OfferApplicationAppliesToVariant1`
- `"addon"` → `PlanChangeVariant3OfferApplicationAppliesToVariant2`
- `"credit_pack"` → `PlanChangeVariant3OfferApplicationAppliesToVariant3`

### PlanChangeVariant3OfferApplicationAppliesToVariant1

- `type` (`string`, required)
- `id` (`string`, required)

### PlanChangeVariant3OfferApplicationAppliesToVariant2

- `type` (`string`, required)
- `id` (`string`, required)

### PlanChangeVariant3OfferApplicationAppliesToVariant3

- `type` (`string`, required)
- `id` (`string`, required)

### PlanChangeVariant3OfferApplicationPhasesItem

Variants:

- `PlanChangeVariant3OfferApplicationPhasesItemVariant1`
- `PlanChangeVariant3OfferApplicationPhasesItemVariant2`
- `PlanChangeVariant3OfferApplicationPhasesItemVariant3`
- `PlanChangeVariant3OfferApplicationPhasesItemVariant4`

Discriminator: `type`

- `"free_trial"` → `PlanChangeVariant3OfferApplicationPhasesItemVariant1`
- `"percentage"` → `PlanChangeVariant3OfferApplicationPhasesItemVariant2`
- `"amount_off"` → `PlanChangeVariant3OfferApplicationPhasesItemVariant3`
- `"fixed_price"` → `PlanChangeVariant3OfferApplicationPhasesItemVariant4`

### PlanChangeVariant3OfferApplicationPhasesItemVariant1

- `type` (`string`, required)
- `durationDays` (`int`, required)
- `startsAt` (`string | null`, required)
- `endsAt` (`string | null`, required)

### PlanChangeVariant3OfferApplicationPhasesItemVariant2

- `type` (`string`, required)
- `durationCycles` (`int | null`, required)
- `durationInterval` (`string | null`, required)
- `startsAt` (`string | null`, required)
- `endsAt` (`string | null`, required)
- `percentage` (`int`, required) — Discount in basis points. 5000 means 50%.

### PlanChangeVariant3OfferApplicationPhasesItemVariant3

- `type` (`string`, required)
- `durationCycles` (`int | null`, required)
- `durationInterval` (`string | null`, required)
- `startsAt` (`string | null`, required)
- `endsAt` (`string | null`, required)
- `amount` (`int`, required) — Discount in the application currency's minor unit.

### PlanChangeVariant3OfferApplicationPhasesItemVariant4

- `type` (`string`, required)
- `durationCycles` (`int | null`, required)
- `durationInterval` (`string | null`, required)
- `startsAt` (`string | null`, required)
- `endsAt` (`string | null`, required)
- `price` (`int`, required) — Fixed price in the application currency's minor unit.

### PlanChangeVariant3PreviousPlan

- `id` (`string`, required)
- `name` (`string`, required)

### PlanCountriesItem

- `country` (`string`, required) — ISO country code.
- `currency` (`string`, required) — The currency buyers from the country pay, USD included.
- `prices` (`array`, required)
- `addons` (`array`, required) — Every add-on the version sells, priced for the country.
- `creditPacks` (`array`, required) — Every credit pack the version sells, priced for the country.

### PlanCountriesItemAddonsItem

- `addonId` (`string`, required)
- `price` (`int`, required) — What buyers from the country pay for the add-on, in the currency's minor unit.
- `manual` (`bool`, required) — True when set by hand; false when it follows the add-on's USD price at the exchange rate.

### PlanCountriesItemCreditPacksItem

- `creditPackId` (`string`, required)
- `price` (`int`, required) — What buyers from the country pay for the pack, in the currency's minor unit.
- `manual` (`bool`, required) — True when set by hand; false when it follows the pack's USD price at the exchange rate.

### PlanCountriesItemPricesItem

- `billingInterval` (`BillingInterval`, required)
- `price` (`int`, required) — The country's price in the currency's minor unit.
- `manual` (`bool`, required) — True when set by hand; false when it follows the USD base at the exchange rate.

### PlanDraft

- `id` (`string`, required) — Public plan draft ID.
- `fromVersionId` (`string`, required) — The version the draft started from.
- `changes` (`array`, required) — What the draft changes against the version it started from.
- `createdAt` (`string`, required)
- `updatedAt` (`string`, required)
- `object` (`string`, required)
- `livemode` (`bool`, required)

### PlanDraftChangesItem

- `key` (`string`, required) — Identifies the change; send it to undo just this change.
- `section` (`string`, required) — Where the change is: Price, Trial, a rules section, Add-ons, or a country.
- `country` (`string | null`, required) — ISO country code when the change belongs to one country.
- `label` (`string`, required) — What changed, such as Monthly price.
- `before` (`string | null`, required) — The value before, formatted.
- `after` (`string | null`, required) — The value now, formatted.

### PlanDraftPublication

- `preview` (`bool`, required)
- `version` (`PlanDraftPublicationVersion | null`, required) — The published version. Null for a preview.
- `moveId` (`string | null`, required) — The move of subscribers, if any.
- `subscribers` (`PlanDraftPublicationSubscribers | null`, required)
- `object` (`string`, required)
- `livemode` (`bool`, required)

### PlanDraftPublicationSubscribers

- `moving` (`int`, required)
- `keptOnVersion` (`int`, required)
- `needsAChange` (`int`, required) — Left on their version because no change makes them fit; they show among the subscribers that need a change.
- `leftOut` (`array`, required)

### PlanDraftPublicationSubscribersLeftOutItem

- `subscriptionId` (`string`, required)
- `code` (`string`, required)
- `message` (`string`, required)

### PlanDraftPublicationVersion

- `id` (`string`, required) — Public plan version ID.
- `label` (`string`, required) — The plan's versions are numbered 1, 2, 3; an experiment's own versions read with its code, such as price-test 2.
- `number` (`int | null`, required) — The plan's version number. Null for a version that only belongs to an experiment; an experiment version made current takes the next number.
- `experiment` (`PlanDraftPublicationVersionExperiment | null`, required) — The experiment this version belongs to, if any.
- `isCurrent` (`bool`, required) — Whether new buyers get this version.
- `parentVersionId` (`string | null`, required) — The version this one was created from.
- `subscriptionCount` (`int`, required) — Active, trialing, past due and paused subscriptions on it.
- `maxPlanCredits` (`int | null`, required)
- `maxPlanBalance` (`int | null`, required)
- `prices` (`array`, required)
- `createdAt` (`string`, required)

### PlanDraftPublicationVersionExperiment

- `code` (`string`, required) — The experiment's code, as sold with planCode.
- `version` (`int`, required) — Its number within the experiment.

### PlanDraftPublicationVersionPricesItem

- `id` (`string`, required) — Public plan price ID.
- `billingInterval` (`string`, required)
- `price` (`int`, required)
- `includedCredits` (`int | null`, required)
- `includedBalance` (`int | null`, required)
- `regionalPrices` (`array`, required)

### PlanDraftPublicationVersionPricesItemRegionalPricesItem

- `currency` (`string`, required)
- `price` (`int`, required)
- `includedBalance` (`int | null`, required)

### PlanExchangeRatesItem

- `currency` (`string`, required)
- `exchangeRate` (`float`, required)

### PlanExperiment

- `id` (`string`, required) — Public plan experiment ID.
- `code` (`string`, required) — The code to sell it with as planCode, such as pro:price-test. It always sells the experiment's latest version while running, and the plan's current version once closed.
- `status` (`string`, required) — running sells its latest version; won became the plan's current version; archived stopped selling.
- `startedFromVersionId` (`string`, required) — The plan's version that was current when it started.
- `latestVersionId` (`string`, required) — Its latest version.
- `sellsVersionId` (`string`, required) — The version its code sells to new buyers today.
- `subscriptionCount` (`int`, required) — Active, trialing, past due and paused subscriptions on its versions.
- `createdAt` (`string`, required)
- `closedAt` (`string | null`, required)
- `object` (`string`, required)
- `livemode` (`bool`, required)

### PlanExperimentArchive

- `experiment` (`PlanExperimentArchiveExperiment`, required)
- `moveId` (`string | null`, required) — The move of its subscribers, or null when they stay.
- `object` (`string`, required)
- `livemode` (`bool`, required)

### PlanExperimentArchiveExperiment

- `id` (`string`, required) — Public plan experiment ID.
- `code` (`string`, required) — The code to sell it with as planCode, such as pro:price-test. It always sells the experiment's latest version while running, and the plan's current version once closed.
- `status` (`string`, required) — running sells its latest version; won became the plan's current version; archived stopped selling.
- `startedFromVersionId` (`string`, required) — The plan's version that was current when it started.
- `latestVersionId` (`string`, required) — Its latest version.
- `sellsVersionId` (`string`, required) — The version its code sells to new buyers today.
- `subscriptionCount` (`int`, required) — Active, trialing, past due and paused subscriptions on its versions.
- `createdAt` (`string`, required)
- `closedAt` (`string | null`, required)

### PlanFeature

- `planId` (`string`, required)
- `featureId` (`string`, required)
- `enabled` (`bool`, required)
- `includedAmount` (`int`, required)
- `unlimited` (`bool`, required)
- `overage` (`PlanFeatureOverage`, required)
- `creditsPerUnit` (`int | null`, required)
- `pricingMode` (`string`, required)
- `margin` (`int | null`, required)
- `object` (`string`, required)
- `livemode` (`bool`, required)

### PlanFeatureOverage

- `enabled` (`bool`, required)
- `unitPrice` (`int`, required)

### PlanFeaturesItem

- `code` (`string`, required)
- `name` (`string`, required)
- `type` (`FeatureType`, required)
- `unitName` (`string | null`, required)
- `enabled` (`bool`, required)
- `includedAmount` (`int | null`, required)
- `unlimited` (`bool`, required)
- `overage` (`PlanFeaturesItemOverage | null`, required)
- `regionalPrices` (`array`, required)

### PlanFeaturesItemOverage

- `enabled` (`bool`, required)
- `model` (`string | null`, required)
- `unitPrice` (`int | null`, required)

### PlanFeaturesItemRegionalPricesItem

- `currency` (`string`, required)
- `overageUnitPrice` (`int | null`, required)
- `autoSynced` (`bool`, required)

### PlanGrant

- `id` (`string`, required)
- `customerId` (`string`, required)
- `subscriptionId` (`string`, required)
- `basePlanId` (`string`, required)
- `planId` (`string`, required)
- `planReleaseId` (`string`, required)
- `status` (`string`, required)
- `duration` (`string`, required)
- `durationCycles` (`int | null`, required)
- `startsAt` (`string`, required)
- `expiresAt` (`string | null`, required)
- `reason` (`string`, required)
- `source` (`string`, required)
- `revokedAt` (`string | null`, required)
- `createdAt` (`string`, required)
- `updatedAt` (`string`, required)
- `events` (`array`, required)
- `object` (`string`, required)
- `livemode` (`bool`, required)

### PlanGrantEventsItem

- `id` (`string`, required)
- `type` (`string`, required)
- `reason` (`string`, required)
- `source` (`string`, required)
- `previousExpiresAt` (`string | null`, required)
- `expiresAt` (`string | null`, required)
- `duration` (`string | null`, required)
- `durationCycles` (`int | null`, required)
- `requestedExpiresAt` (`string | null`, required)
- `createdAt` (`string`, required)

### PlanGroup

- `id` (`string`, required)
- `name` (`string`, required)
- `description` (`string | null`, required)
- `isPublic` (`bool`, required)
- `createdAt` (`string`, required)
- `updatedAt` (`string`, required)
- `object` (`string`, required)
- `livemode` (`bool`, required)

### PlanGroupDetail

- `id` (`string`, required)
- `name` (`string`, required)
- `description` (`string | null`, required)
- `isPublic` (`bool`, required)
- `createdAt` (`string`, required)
- `updatedAt` (`string`, required)
- `plans` (`array`, required)
- `object` (`string`, required)
- `livemode` (`bool`, required)

### PlanGroupDetailPlansItem

- `id` (`string`, required)
- `name` (`string`, required)
- `sortOrder` (`int`, required)

### PlanGroupsListResult

- `object` (`string`, required)
- `data` (`array`, required)
- `hasMore` (`bool`, required)
- `nextCursor` (`string`, optional)

### PlanMove

- `id` (`string | null`, required) — Public move ID. Null for a preview, which records nothing.
- `toVersionId` (`string`, required)
- `fromVersionIds` (`array`, required) — The versions its subscribers are moving from.
- `effective` (`string`, required)
- `preview` (`bool`, required)
- `status` (`string`, required) — checked is a preview where everyone fits; moving while subscribers wait for their move; completed once every move ran; canceled after it was canceled.
- `counts` (`PlanMoveCounts`, required)
- `subscriptions` (`array`, required)
- `createdAt` (`string | null`, required)
- `completedAt` (`string | null`, required)
- `canceledAt` (`string | null`, required)
- `object` (`string`, required)
- `livemode` (`bool`, required)

### PlanMoveCounts

- `moving` (`int`, required)
- `moved` (`int`, required)
- `needsAChange` (`int`, required)
- `leftOut` (`int`, required)
- `canceled` (`int`, required)
- `keptOnVersion` (`int`, required)

### PlanMoveSubscriptionsItem

- `subscriptionId` (`string`, required)
- `status` (`string`, required) — moving waits for its renewal or is being moved; moved is on the destination; needs_a_change could not move and keeps its version until it is resolved or kept; left_out was not moved because it was not active, trialing or past due, such as a paused subscription (invalid_subscription_status), or because a listed subscription was already on the destination (no_change_requested); canceled was canceled before it moved; kept_on_version was left on its version by the merchant.
- `code` (`string | null`, required)
- `message` (`string | null`, required)

### PlanPlanBalanceLimit

- `amount` (`int`, required) — The most plan balance a subscription spends in one window, in USD cents. Other currencies convert it with the plan's exchange rate unless the dashboard sets a custom amount for that currency.
- `interval` (`string`, required) — The window length: `day` is 24 hours and `week` is 7 days, starting at the time of day of the subscription's billing anchor.

### PlanPlanCreditLimit

- `credits` (`int`, required) — The most plan credits a subscription spends in one window.
- `interval` (`string`, required) — The window length: `day` is 24 hours and `week` is 7 days, starting at the time of day of the subscription's billing anchor.

### PlanPrice

- `id` (`string`, required) — Public plan price ID.
- `planId` (`string`, required)
- `billingInterval` (`BillingInterval`, required)
- `price` (`int`, required) — Price in the currency's minor unit (for example, cents for USD).
- `isDefault` (`bool`, required)
- `trialDays` (`int`, required)
- `trialRequiresPaymentMethod` (`bool | null`, required) — Whether the price's free trial needs a payment method to start. When false, a new subscription starts trialing right away without checkout; without a payment method added by the trial end, the customer moves to the plan group's default plan, or the subscription is canceled when there is none. Null when the price has no trial.
- `includedBalance` (`int | null`, required)
- `includedCredits` (`int | null`, required)
- `offerId` (`string | null`, required) — Automatic introductory offer for this price.
- `inheritsFromPriceId` (`string | null`, required) — Public base price ID for a market price variant, or null for a base price.
- `metadata` (`array`, required) — Application metadata. Variant display names may use metadata.name.
- `marketPrices` (`array`, required) — Country-market overrides. Variants inherit their base price for every market not listed.
- `createdAt` (`string`, required)
- `updatedAt` (`string`, required)
- `object` (`string`, required)
- `livemode` (`bool`, required)

### PlanPriceMarketPricesItem

- `marketGroupId` (`string`, required) — Public pricing market group ID.
- `currency` (`string`, required) — Presentment currency for this market.
- `price` (`int`, required) — Market price in the currency's minor unit.

### PlanPricesItem

- `id` (`string`, required) — Public plan price ID.
- `billingInterval` (`BillingInterval`, required)
- `price` (`int`, required) — Price in the currency's minor unit (for example, cents for USD).
- `isDefault` (`bool`, required)
- `trialDays` (`int`, required)
- `trialRequiresPaymentMethod` (`bool | null`, required) — Whether the price's free trial needs a payment method to start. When false, a new subscription starts trialing right away without checkout; without a payment method added by the trial end, the customer moves to the plan group's default plan, or the subscription is canceled when there is none. Null when the price has no trial.
- `includedBalance` (`int | null`, required)
- `includedCredits` (`int | null`, required)
- `offerId` (`string | null`, required) — Automatic introductory offer for this price. Pass a Promotional Offer ID when creating a subscription to override it.
- `inheritsFromPriceId` (`string | null`, required) — Public base price ID for a market price variant, or null for a base price.
- `metadata` (`array`, required) — Application metadata. Variant display names may use metadata.name.
- `marketPrices` (`array`, required) — Country-market overrides. An empty array means currency pricing and then the global USD price remain the fallback.
- `regionalPrices` (`array`, required)

### PlanPricesItemMarketPricesItem

- `marketGroupId` (`string`, required) — Public pricing market group ID.
- `currency` (`string`, required) — Presentment currency for this market.
- `price` (`int`, required) — Market price in the currency's minor unit.

### PlanPricesItemRegionalPricesItem

- `currency` (`string`, required)
- `price` (`int`, required)
- `includedBalance` (`int | null`, required)
- `autoSynced` (`bool`, required)

### PlanRegionalPricing

- `priceId` (`string`, required)
- `overrides` (`array`, required)
- `object` (`string`, required)
- `livemode` (`bool`, required)

### PlanRegionalPricingOverridesItem

- `currency` (`string`, required)
- `price` (`int`, required)
- `includedBalance` (`int`, optional)

### PlanRegionalPricingResult

- `planId` (`string`, required)
- `currency` (`string`, required)
- `exchangeRate` (`float`, required)
- `pricesConfigured` (`int`, required)
- `featuresConfigured` (`int`, required)
- `object` (`string`, required)
- `livemode` (`bool`, required)

### PlansListDraftsResult

- `object` (`string`, required)
- `data` (`array`, required)
- `hasMore` (`bool`, required)
- `nextCursor` (`string`, optional)

### PlansListExperimentsResult

- `object` (`string`, required)
- `data` (`array`, required)
- `hasMore` (`bool`, required)
- `nextCursor` (`string`, optional)

### PlansListMovesResult

- `object` (`string`, required)
- `data` (`array`, required)
- `hasMore` (`bool`, required)
- `nextCursor` (`string`, optional)

### PlansListResult

- `object` (`string`, required)
- `data` (`array`, required)
- `hasMore` (`bool`, required)
- `nextCursor` (`string`, optional)

### PlansListSubscribersNeedingAChangeResult

- `object` (`string`, required)
- `data` (`array`, required)
- `hasMore` (`bool`, required)
- `nextCursor` (`string`, optional)

### PlansListVersionsResult

- `object` (`string`, required)
- `data` (`array`, required)
- `hasMore` (`bool`, required)
- `nextCursor` (`string`, optional)

### PlanUnusedPlanBalance

Variants:

- `PlanUnusedPlanBalanceVariant1`
- `PlanUnusedPlanBalanceVariant2`

Discriminator: `type`

- `"expire"` → `PlanUnusedPlanBalanceVariant1`
- `"roll_over"` → `PlanUnusedPlanBalanceVariant2`

### PlanUnusedPlanBalanceVariant1

- `type` (`string`, required)

### PlanUnusedPlanBalanceVariant2

- `type` (`string`, required)
- `maxPlanBalance` (`int | null`, required) — The most plan balance a subscription holds after a reset, in USD cents, including the balance that reset grants; balance above it expires. At least the included balance of every price. Other currencies convert it with the plan's exchange rate unless the dashboard sets a custom amount for that currency. null means no limit other than the largest storable amount, 2,147,483,647 cents.

### PlanUnusedPlanCredits

Variants:

- `PlanUnusedPlanCreditsVariant1`
- `PlanUnusedPlanCreditsVariant2`

Discriminator: `type`

- `"expire"` → `PlanUnusedPlanCreditsVariant1`
- `"roll_over"` → `PlanUnusedPlanCreditsVariant2`

### PlanUnusedPlanCreditsVariant1

- `type` (`string`, required)

### PlanUnusedPlanCreditsVariant2

- `type` (`string`, required)
- `maxPlanCredits` (`int | null`, required) — The most plan credits a subscription holds after a reset, including the credits that reset grants; credits above it expire. At least the included credits of every price. null means no limit other than the largest storable balance, 2,147,483,647 plan credits.

### PlanVersion

- `id` (`string`, required) — Public plan version ID.
- `label` (`string`, required) — The plan's versions are numbered 1, 2, 3; an experiment's own versions read with its code, such as price-test 2.
- `number` (`int | null`, required) — The plan's version number. Null for a version that only belongs to an experiment; an experiment version made current takes the next number.
- `experiment` (`PlanVersionExperiment | null`, required) — The experiment this version belongs to, if any.
- `isCurrent` (`bool`, required) — Whether new buyers get this version.
- `parentVersionId` (`string | null`, required) — The version this one was created from.
- `subscriptionCount` (`int`, required) — Active, trialing, past due and paused subscriptions on it.
- `maxPlanCredits` (`int | null`, required)
- `maxPlanBalance` (`int | null`, required)
- `prices` (`array`, required)
- `createdAt` (`string`, required)
- `object` (`string`, required)
- `livemode` (`bool`, required)

### PlanVersionComparison

- `versionId` (`string`, required) — The version the changes start from.
- `againstVersionId` (`string`, required) — The version they end at.
- `changes` (`array`, required) — Every term that differs, the plan's first and then each country.
- `object` (`string`, required)
- `livemode` (`bool`, required)

### PlanVersionComparisonChangesItem

- `key` (`string`, required) — Identifies the change; send it to undo just this change.
- `section` (`string`, required) — Where the change is: Price, Trial, a rules section, Add-ons, or a country.
- `country` (`string | null`, required) — ISO country code when the change belongs to one country.
- `label` (`string`, required) — What changed, such as Monthly price.
- `before` (`string | null`, required) — The value before, formatted.
- `after` (`string | null`, required) — The value now, formatted.

### PlanVersionExperiment

- `code` (`string`, required) — The experiment's code, as sold with planCode.
- `version` (`int`, required) — Its number within the experiment.

### PlanVersionPricesItem

- `id` (`string`, required) — Public plan price ID.
- `billingInterval` (`string`, required)
- `price` (`int`, required)
- `includedCredits` (`int | null`, required)
- `includedBalance` (`int | null`, required)
- `regionalPrices` (`array`, required)

### PlanVersionPricesItemRegionalPricesItem

- `currency` (`string`, required)
- `price` (`int`, required)
- `includedBalance` (`int | null`, required)

### PortalAccess

- `portalUrl` (`string`, required)
- `object` (`string`, required)
- `livemode` (`bool`, required)

### PrepaidPeriodsCheckout

- `checkoutUrl` (`string`, required)
- `object` (`string`, required)
- `livemode` (`bool`, required)

### PreviewChange

- `currency` (`string`, required)
- `currentPlanCredit` (`int`, required)
- `newPlanCharge` (`int`, required)
- `estimatedTotal` (`int`, required)
- `effectiveDate` (`string`, required)
- `daysRemaining` (`int`, required)
- `totalDays` (`int`, required)
- `isUpgrade` (`bool`, required)
- `deactivatedAddons` (`array`, required) — Active add-ons that the version the change moves the subscription to does not sell. The change deactivates them when it applies.
- `offerApplication` (`PreviewChangeOfferApplication`, optional)
- `object` (`string`, required)
- `livemode` (`bool`, required)

### PreviewChangeDeactivatedAddonsItem

- `addonId` (`string`, required)
- `name` (`string`, required)

### PreviewChangeOfferApplication

- `id` (`string`, required)
- `offerId` (`string`, required)
- `name` (`string`, required)
- `currency` (`string`, required)
- `subtotal` (`int`, required) — Subtotal in the currency's minor unit.
- `discountAmount` (`int`, required) — Discount in the currency's minor unit.
- `total` (`int`, required) — Total in the currency's minor unit.
- `phases` (`array`, required)
- `appliesTo` (`PreviewChangeOfferApplicationAppliesTo`, required)

### PreviewChangeOfferApplicationAppliesTo

Variants:

- `PreviewChangeOfferApplicationAppliesToVariant1`
- `PreviewChangeOfferApplicationAppliesToVariant2`
- `PreviewChangeOfferApplicationAppliesToVariant3`

Discriminator: `type`

- `"plan_price"` → `PreviewChangeOfferApplicationAppliesToVariant1`
- `"addon"` → `PreviewChangeOfferApplicationAppliesToVariant2`
- `"credit_pack"` → `PreviewChangeOfferApplicationAppliesToVariant3`

### PreviewChangeOfferApplicationAppliesToVariant1

- `type` (`string`, required)
- `id` (`string`, required)

### PreviewChangeOfferApplicationAppliesToVariant2

- `type` (`string`, required)
- `id` (`string`, required)

### PreviewChangeOfferApplicationAppliesToVariant3

- `type` (`string`, required)
- `id` (`string`, required)

### PreviewChangeOfferApplicationPhasesItem

Variants:

- `PreviewChangeOfferApplicationPhasesItemVariant1`
- `PreviewChangeOfferApplicationPhasesItemVariant2`
- `PreviewChangeOfferApplicationPhasesItemVariant3`
- `PreviewChangeOfferApplicationPhasesItemVariant4`

Discriminator: `type`

- `"free_trial"` → `PreviewChangeOfferApplicationPhasesItemVariant1`
- `"percentage"` → `PreviewChangeOfferApplicationPhasesItemVariant2`
- `"amount_off"` → `PreviewChangeOfferApplicationPhasesItemVariant3`
- `"fixed_price"` → `PreviewChangeOfferApplicationPhasesItemVariant4`

### PreviewChangeOfferApplicationPhasesItemVariant1

- `type` (`string`, required)
- `durationDays` (`int`, required)
- `startsAt` (`string | null`, required)
- `endsAt` (`string | null`, required)

### PreviewChangeOfferApplicationPhasesItemVariant2

- `type` (`string`, required)
- `durationCycles` (`int | null`, required)
- `durationInterval` (`string | null`, required)
- `startsAt` (`string | null`, required)
- `endsAt` (`string | null`, required)
- `percentage` (`int`, required) — Discount in basis points. 5000 means 50%.

### PreviewChangeOfferApplicationPhasesItemVariant3

- `type` (`string`, required)
- `durationCycles` (`int | null`, required)
- `durationInterval` (`string | null`, required)
- `startsAt` (`string | null`, required)
- `endsAt` (`string | null`, required)
- `amount` (`int`, required) — Discount in the application currency's minor unit.

### PreviewChangeOfferApplicationPhasesItemVariant4

- `type` (`string`, required)
- `durationCycles` (`int | null`, required)
- `durationInterval` (`string | null`, required)
- `startsAt` (`string | null`, required)
- `endsAt` (`string | null`, required)
- `price` (`int`, required) — Fixed price in the application currency's minor unit.

### PromoCode

- `id` (`string`, required)
- `code` (`string`, required)
- `offerId` (`string`, required)
- `billingInterval` (`BillingInterval | null`, required)
- `maxRedemptions` (`int | null`, required)
- `expiresAt` (`string | null`, required)
- `isActive` (`bool`, required)
- `redemptionCount` (`int`, required)
- `firstPurchaseOnly` (`bool`, required) — Whether the code only applies to a customer's first purchase: one with no paid invoice above zero and no paid subscription.
- `managedBy` (`ManagedBy`, required) — Integration that manages this record, or null when the merchant does. While an integration manages it, its terms change only in that integration and edits answer 409 managed_by_integration.
- `createdAt` (`string`, required)
- `updatedAt` (`string`, required)
- `object` (`string`, required)
- `livemode` (`bool`, required)

### PromoCodesListResult

- `object` (`string`, required)
- `data` (`array`, required)
- `hasMore` (`bool`, required)
- `nextCursor` (`string`, optional)

### PublishPlanDraftParamsChangesItem

- `subscriptionId` (`string`, required)
- `keepOnVersion` (`mixed`, optional) — Leave this subscriber on its version.
- `billingInterval` (`string`, optional)
- `seatLimit` (`mixed`, optional) — Lower its seats to the version's limit at renewal.
- `removeAddonIds` (`array`, optional) — Add-ons it stops paying at renewal.

### QuotaGetAllResult

- `object` (`string`, required)
- `data` (`array`, required)
- `hasMore` (`bool`, required)
- `nextCursor` (`string`, optional)

### ReactivatedSubscription

- `subscriptionId` (`string`, required)
- `invoiceId` (`string`, required)
- `status` (`string`, required)
- `offerApplication` (`ReactivatedSubscriptionOfferApplication`, optional)
- `object` (`string`, required)
- `livemode` (`bool`, required)

### ReactivatedSubscriptionOfferApplication

- `id` (`string`, required)
- `offerId` (`string`, required)
- `name` (`string`, required)
- `currency` (`string`, required)
- `subtotal` (`int`, required) — Subtotal in the currency's minor unit.
- `discountAmount` (`int`, required) — Discount in the currency's minor unit.
- `total` (`int`, required) — Total in the currency's minor unit.
- `phases` (`array`, required)
- `appliesTo` (`ReactivatedSubscriptionOfferApplicationAppliesTo`, required)

### ReactivatedSubscriptionOfferApplicationAppliesTo

Variants:

- `ReactivatedSubscriptionOfferApplicationAppliesToVariant1`
- `ReactivatedSubscriptionOfferApplicationAppliesToVariant2`
- `ReactivatedSubscriptionOfferApplicationAppliesToVariant3`

Discriminator: `type`

- `"plan_price"` → `ReactivatedSubscriptionOfferApplicationAppliesToVariant1`
- `"addon"` → `ReactivatedSubscriptionOfferApplicationAppliesToVariant2`
- `"credit_pack"` → `ReactivatedSubscriptionOfferApplicationAppliesToVariant3`

### ReactivatedSubscriptionOfferApplicationAppliesToVariant1

- `type` (`string`, required)
- `id` (`string`, required)

### ReactivatedSubscriptionOfferApplicationAppliesToVariant2

- `type` (`string`, required)
- `id` (`string`, required)

### ReactivatedSubscriptionOfferApplicationAppliesToVariant3

- `type` (`string`, required)
- `id` (`string`, required)

### ReactivatedSubscriptionOfferApplicationPhasesItem

Variants:

- `ReactivatedSubscriptionOfferApplicationPhasesItemVariant1`
- `ReactivatedSubscriptionOfferApplicationPhasesItemVariant2`
- `ReactivatedSubscriptionOfferApplicationPhasesItemVariant3`
- `ReactivatedSubscriptionOfferApplicationPhasesItemVariant4`

Discriminator: `type`

- `"free_trial"` → `ReactivatedSubscriptionOfferApplicationPhasesItemVariant1`
- `"percentage"` → `ReactivatedSubscriptionOfferApplicationPhasesItemVariant2`
- `"amount_off"` → `ReactivatedSubscriptionOfferApplicationPhasesItemVariant3`
- `"fixed_price"` → `ReactivatedSubscriptionOfferApplicationPhasesItemVariant4`

### ReactivatedSubscriptionOfferApplicationPhasesItemVariant1

- `type` (`string`, required)
- `durationDays` (`int`, required)
- `startsAt` (`string | null`, required)
- `endsAt` (`string | null`, required)

### ReactivatedSubscriptionOfferApplicationPhasesItemVariant2

- `type` (`string`, required)
- `durationCycles` (`int | null`, required)
- `durationInterval` (`string | null`, required)
- `startsAt` (`string | null`, required)
- `endsAt` (`string | null`, required)
- `percentage` (`int`, required) — Discount in basis points. 5000 means 50%.

### ReactivatedSubscriptionOfferApplicationPhasesItemVariant3

- `type` (`string`, required)
- `durationCycles` (`int | null`, required)
- `durationInterval` (`string | null`, required)
- `startsAt` (`string | null`, required)
- `endsAt` (`string | null`, required)
- `amount` (`int`, required) — Discount in the application currency's minor unit.

### ReactivatedSubscriptionOfferApplicationPhasesItemVariant4

- `type` (`string`, required)
- `durationCycles` (`int | null`, required)
- `durationInterval` (`string | null`, required)
- `startsAt` (`string | null`, required)
- `endsAt` (`string | null`, required)
- `price` (`int`, required) — Fixed price in the application currency's minor unit.

### RecoveryLink

- `url` (`string`, required)
- `token` (`string`, required)
- `object` (`string`, required)
- `livemode` (`bool`, required)

### Refund

- `id` (`string`, required)
- `transactionId` (`string`, required)
- `amount` (`int`, required)
- `currency` (`string`, required)
- `chargeId` (`string | null`, required)
- `status` (`string`, required)
- `reason` (`string | null`, required)
- `object` (`string`, required)
- `livemode` (`bool`, required)

### RemovedPlanFeature

- `id` (`string`, required)
- `removed` (`mixed`, required)
- `object` (`string`, required)
- `livemode` (`bool`, required)

### RemovedPlanFromGroup

- `id` (`string`, required)
- `removed` (`bool`, required)
- `object` (`string`, required)
- `livemode` (`bool`, required)

### ReorderedPlans

- `reordered` (`bool`, required)
- `object` (`string`, required)
- `livemode` (`bool`, required)

### SeatBalance

- `current` (`int`, required)
- `asOf` (`string`, required)
- `object` (`string`, required)
- `livemode` (`bool`, required)

### SeatBalanceCollection

- `balances` (`array`, required)
- `object` (`string`, required)
- `livemode` (`bool`, required)

### SeatBalanceCollectionBalancesValue

- `current` (`int`, required)
- `asOf` (`string`, required)

### SeatEvent

- `id` (`string`, required)
- `customerId` (`string`, required)
- `featureCode` (`string`, required)
- `previousBalance` (`int`, required)
- `newBalance` (`int`, required)
- `ts` (`string`, required)
- `createdAt` (`string`, required)
- `object` (`string`, required)
- `livemode` (`bool`, required)

### SeatsSetAllResult

- `object` (`string`, required)
- `data` (`array`, required)
- `hasMore` (`bool`, required)
- `nextCursor` (`string`, optional)

### SentInvoice

- `sent` (`bool`, required)
- `sentAt` (`string`, required)
- `object` (`string`, required)
- `livemode` (`bool`, required)

### SetPlanRegionalPricingParamsFeaturesItem

- `featureId` (`string`, required)
- `overageUnitPrice` (`int`, required)

### SetPlanRegionalPricingParamsPricesItem

- `priceId` (`string`, required)
- `price` (`int`, required)
- `includedBalance` (`int`, optional)

### SubscriberNeedingAChange

- `subscriptionId` (`string`, required)
- `moveId` (`string`, required) — The move it could not complete.
- `fromVersionId` (`string`, required) — The version it stays on.
- `toVersionId` (`string`, required) — The version it could not move to.
- `code` (`string`, required) — Why it could not move.
- `message` (`string`, required)
- `object` (`string`, required)
- `livemode` (`bool`, required)

### Subscription

- `id` (`string`, required)
- `customerId` (`string`, required)
- `plan` (`SubscriptionPlan`, required)
- `name` (`string`, required)
- `description` (`string | null`, required)
- `status` (`SubscriptionStatus`, required)
- `billingInterval` (`BillingInterval | null`, required)
- `trialEndsAt` (`string | null`, required)
- `currentPeriod` (`SubscriptionCurrentPeriod | null`, required)
- `cancellation` (`SubscriptionCancellation | null`, required)
- `cancelAtPeriodEnd` (`bool`, required)
- `scheduledPlanChange` (`SubscriptionScheduledPlanChange | null`, required)
- `startDate` (`string`, required)
- `endDate` (`string | null`, required)
- `billingDayOfMonth` (`int | null`, required)
- `nextBillingDate` (`string | null`, required)
- `checkoutUrl` (`string | null`, required)
- `hasPaymentMethod` (`bool`, required) — Whether Commet can charge this subscription on its own at its next charge (the trial end or the renewal). A trial that started without a payment method reports false until the customer adds one for this subscription; a payment method saved for another subscription does not count. A subscription on a free plan reports false.
- `createdAt` (`string`, required)
- `updatedAt` (`string`, required)
- `planVersion` (`SubscriptionPlanVersion | null`, required) — The plan version whose terms the subscription has now. It keeps paying and receiving everything from this version until it is moved.
- `offerApplications` (`array`, required)
- `pause` (`SubscriptionPause | null`, required)
- `scheduledVersionChange` (`SubscriptionScheduledVersionChange | null`, required) — A move to another version of the plan pending for the next renewal.
- `planGrant` (`SubscriptionPlanGrant`, optional)
- `consumptionModel` (`ConsumptionModel | null`, required)
- `features` (`array`, required)
- `credits` (`SubscriptionCredits | null`, required)
- `balance` (`SubscriptionBalance | null`, required)
- `priceId` (`string | null`, required)
- `object` (`string`, required)
- `livemode` (`bool`, required)

### SubscriptionAddon

- `addonId` (`string`, required)
- `status` (`string`, required)
- `proratedCharge` (`int`, required)
- `object` (`string`, required)
- `livemode` (`bool`, required)

### SubscriptionAutoTopUp

- `enabled` (`bool`, required) — Whether top-ups run automatically: credits bought on a credits plan, balance added on a balance plan. Always false when the plan does not sell credits or has balance top-ups turned off.
- `threshold` (`int | null`, required) — The available amount at or below which a top-up runs, or null when never configured: credits (plan plus purchased) on a credits plan, minor units of the subscription currency (plan plus purchased balance) on a balance plan.
- `quantity` (`int | null`, required) — Credits each top-up buys on a credits plan, or null when never configured or on a balance plan.
- `amount` (`int | null`, required) — Minor units of the subscription currency each top-up adds on a balance plan, charged plus tax, or null when never configured or on a credits plan.
- `maxPerPeriod` (`int | null`, required) — Maximum top-ups per renewal period, or null when never configured.
- `status` (`string`, required) — active tops up when the available amount reaches the threshold; paused stops after three consecutive failed top-ups, or after one whose charge could not be refunded, until the payment method changes, a credit purchase or balance top-up succeeds or it is saved enabled again; off tops up nothing.
- `topUpsThisPeriod` (`int`, required) — Top-ups made in the current renewal period.
- `periodResetsAt` (`string | null`, required) — When the top-up count of the period resets, or null before the subscription starts its first period.
- `lastFailure` (`SubscriptionAutoTopUpLastFailure | null`, required) — The last top-up that failed, or null when none has failed.
- `object` (`string`, required)
- `livemode` (`bool`, required)

### SubscriptionAutoTopUpLastFailure

- `reason` (`string`, required)
- `at` (`string`, required)

### SubscriptionBalance

- `remaining` (`float`, required) — Balance available in minor units of the subscription currency. Kept for compatibility; equal to `total`.
- `included` (`float`, required)
- `currency` (`string`, required)
- `plan` (`float`, required) — Plan balance left this period, in minor units. Spent first and replaced or rolled over at each reset; negative while overage is owed.
- `purchased` (`float`, required) — Purchased balance in minor units: top-ups and manual adjustments. Spent after the plan balance and kept until the subscription ends.
- `total` (`float`, required) — Balance available in minor units: `plan` plus `purchased`.

### SubscriptionCancellation

- `scheduledAt` (`string`, required)
- `reason` (`string | null`, required)
- `effectiveAt` (`string`, required)

### SubscriptionCredits

- `remaining` (`float`, required) — Plan credits left. Kept for compatibility; equal to `plan`.
- `included` (`float`, required)
- `purchased` (`float`, required) — Purchased credits: purchases and manual adjustments. Spent after plan credits and kept until the subscription ends.
- `plan` (`float`, required) — Plan credits left this period. Spent first and replaced or rolled over at each reset; negative while overage is owed.
- `total` (`float`, required) — Credits available: `plan` plus `purchased`.

### SubscriptionCurrentPeriod

- `start` (`string`, required)
- `end` (`string`, required)
- `daysRemaining` (`float`, required)

### SubscriptionFeaturesItem

Variants:

- `SubscriptionFeaturesItemVariant1`
- `SubscriptionFeaturesItemVariant2`
- `SubscriptionFeaturesItemVariant3`
- `SubscriptionFeaturesItemVariant4`

Discriminator: `type`

- `"boolean"` → `SubscriptionFeaturesItemVariant1`
- `"usage"` → `SubscriptionFeaturesItemVariant2`
- `"seats"` → `SubscriptionFeaturesItemVariant3`
- `"quota"` → `SubscriptionFeaturesItemVariant4`

### SubscriptionFeaturesItemVariant1

- `code` (`string`, required)
- `name` (`string`, required)
- `type` (`string`, required)
- `enabled` (`bool`, required)
- `baseAccess` (`SubscriptionFeaturesItemVariant1BaseAccess | null`, optional)

### SubscriptionFeaturesItemVariant1BaseAccess

- `enabled` (`bool`, required)

### SubscriptionFeaturesItemVariant2

- `code` (`string`, required)
- `name` (`string`, required)
- `type` (`string`, required)
- `usage` (`SubscriptionFeaturesItemVariant2Usage`, optional)
- `baseAccess` (`SubscriptionFeaturesItemVariant2BaseAccess | null`, optional)

### SubscriptionFeaturesItemVariant2BaseAccess

- `included` (`float`, required)
- `unlimited` (`bool`, required)

### SubscriptionFeaturesItemVariant2Usage

- `current` (`float`, required)
- `included` (`float`, required)
- `overageQuantity` (`float`, required)
- `overageUnitPrice` (`float`, optional)
- `unlimited` (`bool`, optional)

### SubscriptionFeaturesItemVariant3

- `code` (`string`, required)
- `name` (`string`, required)
- `type` (`string`, required)
- `usage` (`SubscriptionFeaturesItemVariant3Usage`, required)
- `baseAccess` (`SubscriptionFeaturesItemVariant3BaseAccess | null`, optional)

### SubscriptionFeaturesItemVariant3BaseAccess

- `included` (`float`, required)
- `unlimited` (`bool`, required)

### SubscriptionFeaturesItemVariant3Usage

- `current` (`float`, required)
- `included` (`float`, required)
- `overageQuantity` (`float`, required)
- `overageUnitPrice` (`float`, optional)
- `unlimited` (`bool`, optional)

### SubscriptionFeaturesItemVariant4

- `code` (`string`, required)
- `name` (`string`, required)
- `type` (`string`, required)
- `usage` (`SubscriptionFeaturesItemVariant4Usage`, optional)
- `baseAccess` (`SubscriptionFeaturesItemVariant4BaseAccess | null`, optional)

### SubscriptionFeaturesItemVariant4BaseAccess

- `included` (`float`, required)
- `unlimited` (`bool`, required)

### SubscriptionFeaturesItemVariant4Usage

- `current` (`float`, required)
- `included` (`float`, required)
- `overageQuantity` (`float`, required)
- `overageUnitPrice` (`float`, optional)
- `unlimited` (`bool`, optional)

### SubscriptionOfferApplication

- `id` (`string`, required)
- `name` (`string`, required)
- `appliesTo` (`SubscriptionOfferApplicationAppliesTo`, required)
- `offerId` (`string | null`, required)
- `source` (`string`, required)
- `status` (`string`, required)
- `currency` (`string | null`, required)
- `subtotal` (`int | null`, required)
- `discountAmount` (`int | null`, required)
- `total` (`int | null`, required)
- `phases` (`array`, required)
- `quotedAt` (`string`, required)
- `expiresAt` (`string | null`, required)
- `appliedAt` (`string | null`, required)

### SubscriptionOfferApplicationAppliesTo

Variants:

- `SubscriptionOfferApplicationAppliesToVariant1`
- `SubscriptionOfferApplicationAppliesToVariant2`
- `SubscriptionOfferApplicationAppliesToVariant3`

Discriminator: `type`

- `"plan_price"` → `SubscriptionOfferApplicationAppliesToVariant1`
- `"addon"` → `SubscriptionOfferApplicationAppliesToVariant2`
- `"credit_pack"` → `SubscriptionOfferApplicationAppliesToVariant3`

### SubscriptionOfferApplicationAppliesToVariant1

- `type` (`string`, required)
- `id` (`string`, required)

### SubscriptionOfferApplicationAppliesToVariant2

- `type` (`string`, required)
- `id` (`string`, required)

### SubscriptionOfferApplicationAppliesToVariant3

- `type` (`string`, required)
- `id` (`string`, required)

### SubscriptionOfferApplicationPhase

Variants:

- `SubscriptionOfferApplicationPhaseVariant1`
- `SubscriptionOfferApplicationPhaseVariant2`
- `SubscriptionOfferApplicationPhaseVariant3`
- `SubscriptionOfferApplicationPhaseVariant4`

Discriminator: `type`

- `"free_trial"` → `SubscriptionOfferApplicationPhaseVariant1`
- `"percentage"` → `SubscriptionOfferApplicationPhaseVariant2`
- `"amount_off"` → `SubscriptionOfferApplicationPhaseVariant3`
- `"fixed_price"` → `SubscriptionOfferApplicationPhaseVariant4`

### SubscriptionOfferApplicationPhaseVariant1

- `type` (`string`, required)
- `durationDays` (`int`, required)
- `durationInterval` (`string | null`, required)
- `startsAt` (`string | null`, required)
- `endsAt` (`string | null`, required)

### SubscriptionOfferApplicationPhaseVariant2

- `type` (`string`, required)
- `durationCycles` (`int | null`, required)
- `durationInterval` (`string | null`, required)
- `percentage` (`int`, required)
- `startsAt` (`string | null`, required)
- `endsAt` (`string | null`, required)

### SubscriptionOfferApplicationPhaseVariant3

- `type` (`string`, required)
- `durationCycles` (`int | null`, required)
- `durationInterval` (`string | null`, required)
- `amount` (`int`, required)
- `startsAt` (`string | null`, required)
- `endsAt` (`string | null`, required)

### SubscriptionOfferApplicationPhaseVariant4

- `type` (`string`, required)
- `durationCycles` (`int | null`, required)
- `durationInterval` (`string | null`, required)
- `price` (`int`, required)
- `startsAt` (`string | null`, required)
- `endsAt` (`string | null`, required)

### SubscriptionPause

Variants:

- `SubscriptionPauseVariant1`
- `SubscriptionPauseVariant2`

Discriminator: `status`

- `"scheduled"` → `SubscriptionPauseVariant1`
- `"active"` → `SubscriptionPauseVariant2`

### SubscriptionPauseVariant1

- `status` (`string`, required)
- `mode` (`string`, required)
- `requestedAt` (`string`, required)
- `effectiveAt` (`string`, required)
- `resumeAt` (`string | null`, required)

### SubscriptionPauseVariant2

- `status` (`string`, required)
- `mode` (`string`, required)
- `requestedAt` (`string`, required)
- `effectiveAt` (`string`, required)
- `resumeAt` (`string | null`, required)

### SubscriptionPlan

- `id` (`string`, required)
- `name` (`string`, required)
- `basePrice` (`float`, required)

### SubscriptionPlanGrant

- `id` (`string`, required) — The active Plan Grant ID.
- `plan` (`SubscriptionPlanGrantPlan`, required) — The higher plan whose access is temporarily applied.
- `expiresAt` (`string | null`, required) — When the temporary access ends, or null when it lasts until revoked.

### SubscriptionPlanGrantPlan

- `id` (`string`, required)
- `name` (`string`, required)

### SubscriptionPlanVersion

- `id` (`string`, required) — Public plan version ID.
- `label` (`string`, required) — Main versions are 1, 2, 3; an experiment's versions carry its own code, like price-test 2.

### SubscriptionResume

- `subscriptionId` (`string`, required)
- `invoiceId` (`string | null`, required)
- `status` (`string`, required)
- `object` (`string`, required)
- `livemode` (`bool`, required)

### SubscriptionScheduledPlanChange

- `changeType` (`string`, required)
- `newPlanId` (`string | null`, required)
- `newPlanName` (`string | null`, required)
- `newBillingInterval` (`string | null`, required)
- `scheduledFor` (`string`, required)

### SubscriptionScheduledVersionChange

- `planVersionId` (`string`, required)
- `label` (`string`, required)
- `effectiveAt` (`string`, required)

### SubscriptionsListResult

- `object` (`string`, required)
- `data` (`array`, required)
- `hasMore` (`bool`, required)
- `nextCursor` (`string`, optional)

### SubscriptionSummary

- `id` (`string`, required)
- `customerId` (`string`, required)
- `plan` (`SubscriptionSummaryPlan`, required)
- `name` (`string`, required)
- `description` (`string | null`, required)
- `status` (`SubscriptionStatus`, required)
- `billingInterval` (`BillingInterval | null`, required)
- `trialEndsAt` (`string | null`, required)
- `currentPeriod` (`SubscriptionSummaryCurrentPeriod | null`, required)
- `cancellation` (`SubscriptionSummaryCancellation | null`, required)
- `cancelAtPeriodEnd` (`bool`, required)
- `scheduledPlanChange` (`SubscriptionSummaryScheduledPlanChange | null`, required)
- `startDate` (`string`, required)
- `endDate` (`string | null`, required)
- `billingDayOfMonth` (`int | null`, required)
- `nextBillingDate` (`string | null`, required)
- `checkoutUrl` (`string | null`, required)
- `hasPaymentMethod` (`bool`, required) — Whether Commet can charge this subscription on its own at its next charge (the trial end or the renewal). A trial that started without a payment method reports false until the customer adds one for this subscription; a payment method saved for another subscription does not count. A subscription on a free plan reports false.
- `createdAt` (`string`, required)
- `updatedAt` (`string`, required)
- `planVersion` (`SubscriptionSummaryPlanVersion | null`, required) — The plan version whose terms the subscription has now. It keeps paying and receiving everything from this version until it is moved.
- `offerApplications` (`array`, required)
- `pause` (`SubscriptionSummaryPause | null`, required)
- `priceId` (`string | null`, required)
- `object` (`string`, required)
- `livemode` (`bool`, required)

### SubscriptionSummaryCancellation

- `scheduledAt` (`string`, required)
- `reason` (`string | null`, required)
- `effectiveAt` (`string`, required)

### SubscriptionSummaryCurrentPeriod

- `start` (`string`, required)
- `end` (`string`, required)
- `daysRemaining` (`float`, required)

### SubscriptionSummaryPause

Variants:

- `SubscriptionSummaryPauseVariant1`
- `SubscriptionSummaryPauseVariant2`

Discriminator: `status`

- `"scheduled"` → `SubscriptionSummaryPauseVariant1`
- `"active"` → `SubscriptionSummaryPauseVariant2`

### SubscriptionSummaryPauseVariant1

- `status` (`string`, required)
- `mode` (`string`, required)
- `requestedAt` (`string`, required)
- `effectiveAt` (`string`, required)
- `resumeAt` (`string | null`, required)

### SubscriptionSummaryPauseVariant2

- `status` (`string`, required)
- `mode` (`string`, required)
- `requestedAt` (`string`, required)
- `effectiveAt` (`string`, required)
- `resumeAt` (`string | null`, required)

### SubscriptionSummaryPlan

- `id` (`string`, required)
- `name` (`string`, required)

### SubscriptionSummaryPlanVersion

- `id` (`string`, required) — Public plan version ID.
- `label` (`string`, required) — Main versions are 1, 2, 3; an experiment's versions carry its own code, like price-test 2.

### SubscriptionSummaryScheduledPlanChange

- `changeType` (`string`, required)
- `newPlanId` (`string | null`, required)
- `newPlanName` (`string | null`, required)
- `newBillingInterval` (`string | null`, required)
- `scheduledFor` (`string`, required)

### TestClock

- `simulatedTime` (`string | null`, required)
- `isActive` (`bool`, required)
- `now` (`string`, required)
- `latestRun` (`TestClockLatestRun | null`, required)
- `object` (`string`, required)
- `livemode` (`bool`, required)

### TestClockLatestRun

- `id` (`string`, required)
- `status` (`string`, required)
- `startedAtTime` (`string`, required)
- `targetTime` (`string`, required)
- `estimatedDeadlineCount` (`int`, required)
- `completedDeadlineCount` (`int`, required)
- `failedDeadlineCount` (`int`, required)
- `error` (`string | null`, required)
- `items` (`array`, required)

### TestClockLatestRunItemsItem

- `kind` (`string`, required)
- `status` (`string`, required)
- `dueAt` (`string`, required)
- `subscriptionId` (`string`, required)
- `customerName` (`string | null`, required)
- `invoiceNumber` (`string | null`, required)
- `invoiceId` (`string | null`, required)
- `outcome` (`string | null`, required)
- `detail` (`string | null`, required)
- `error` (`string | null`, required)

### TestClockRun

- `id` (`string`, required)
- `status` (`string`, required)
- `startedAtTime` (`string`, required)
- `targetTime` (`string`, required)
- `estimatedDeadlineCount` (`int`, required)
- `completedDeadlineCount` (`int`, required)
- `failedDeadlineCount` (`int`, required)
- `error` (`string | null`, required)
- `items` (`array`, required)
- `object` (`string`, required)
- `livemode` (`bool`, required)

### TestClockRunItemsItem

- `kind` (`string`, required)
- `status` (`string`, required)
- `dueAt` (`string`, required)
- `subscriptionId` (`string`, required)
- `customerName` (`string | null`, required)
- `invoiceNumber` (`string | null`, required)
- `invoiceId` (`string | null`, required)
- `outcome` (`string | null`, required)
- `detail` (`string | null`, required)
- `error` (`string | null`, required)

### TrackUsageParamsPropertiesItem

- `property` (`string`, required)
- `value` (`string`, required)

### Transaction

- `paymentContext` (`TransactionPaymentContext | null`, required) — Charge context captured for new payments. Null for historical payments with no captured context.
- `id` (`string`, required)
- `invoiceId` (`string | null`, required)
- `grossAmount` (`int | null`, required) — Gross amount in USD cents. Null when the provider has not reported an honest USD figure; see presentmentAmount.
- `subtotal` (`int | null`, required) — Subtotal in USD cents (gross minus tax). Null when grossAmount is null.
- `taxAmount` (`int | null`, required)
- `presentmentAmount` (`int | null`, required) — Amount in the charge currency's smallest unit, as presented to the customer. Set for non-USD charges; null when the charge was made in USD.
- `amountRefunded` (`int`, required) — Cumulative confirmed refunds in the payment currency’s smallest unit.
- `currency` (`string`, required)
- `provider` (`PaymentProvider`, required) — The payment provider the charge was routed to: stripe, commet, or dlocal.
- `paymentMethod` (`PaymentMethod | null`, required) — The method used for this charge: card, oxxo, or mercado_pago. Null when unknown.
- `subPaymentMethod` (`SubPaymentMethod | null`, required) — The source of funds for this charge, when reported by the provider. Null when unavailable or unknown.
- `status` (`TransactionStatus`, required)
- `customerEmail` (`string | null`, required)
- `customerName` (`string | null`, required)
- `paidAt` (`string | null`, required)
- `createdAt` (`string`, required)
- `updatedAt` (`string`, required)
- `availableAt` (`string | null`, required)
- `object` (`string`, required)
- `livemode` (`bool`, required)

### TransactionListItem

- `paymentContext` (`TransactionListItemPaymentContext | null`, required) — Charge context captured for new payments. Null for historical payments with no captured context.
- `id` (`string`, required)
- `invoiceId` (`string | null`, required)
- `grossAmount` (`int | null`, required) — Gross amount in USD cents. Null when the provider has not reported an honest USD figure; see presentmentAmount.
- `subtotal` (`int | null`, required) — Subtotal in USD cents (gross minus tax). Null when grossAmount is null.
- `taxAmount` (`int | null`, required)
- `presentmentAmount` (`int | null`, required) — Amount in the charge currency's smallest unit, as presented to the customer. Set for non-USD charges; null when the charge was made in USD.
- `amountRefunded` (`int`, required) — Cumulative confirmed refunds in the payment currency’s smallest unit.
- `currency` (`string`, required)
- `provider` (`PaymentProvider`, required) — The payment provider the charge was routed to: stripe, commet, or dlocal.
- `paymentMethod` (`PaymentMethod | null`, required) — The method used for this charge: card, oxxo, or mercado_pago. Null when unknown.
- `subPaymentMethod` (`SubPaymentMethod | null`, required) — The source of funds for this charge, when reported by the provider. Null when unavailable or unknown.
- `status` (`TransactionStatus`, required)
- `customerEmail` (`string | null`, required)
- `customerName` (`string | null`, required)
- `paidAt` (`string | null`, required)
- `createdAt` (`string`, required)
- `updatedAt` (`string`, required)
- `object` (`string`, required)
- `livemode` (`bool`, required)

### TransactionListItemPaymentContext

- `reason` (`string`, required) — The original reason for the charge. Recovery never replaces this reason.
- `paymentLinkId` (`string | null`, required) — The public payment link ID, independently of the reason, or null when no payment link originated the charge.
- `recovery` (`TransactionListItemPaymentContextRecovery | null`, required)

### TransactionListItemPaymentContextRecovery

Variants:

- `TransactionListItemPaymentContextRecoveryVariant1`
- `TransactionListItemPaymentContextRecoveryVariant2`

Discriminator: `type`

- `"payment_recovery"` → `TransactionListItemPaymentContextRecoveryVariant1`
- `"dunning_retry"` → `TransactionListItemPaymentContextRecoveryVariant2`

### TransactionListItemPaymentContextRecoveryVariant1

- `type` (`string`, required)

### TransactionListItemPaymentContextRecoveryVariant2

- `type` (`string`, required)
- `attempt` (`int`, required) — Current retry, starting at 1. The original decline is not a retry.
- `maxAttempts` (`int`, required) — Total retries applicable to this charge's dunning schedule.

### TransactionPaymentContext

- `reason` (`string`, required) — The original reason for the charge. Recovery never replaces this reason.
- `paymentLinkId` (`string | null`, required) — The public payment link ID, independently of the reason, or null when no payment link originated the charge.
- `recovery` (`TransactionPaymentContextRecovery | null`, required)

### TransactionPaymentContextRecovery

Variants:

- `TransactionPaymentContextRecoveryVariant1`
- `TransactionPaymentContextRecoveryVariant2`

Discriminator: `type`

- `"payment_recovery"` → `TransactionPaymentContextRecoveryVariant1`
- `"dunning_retry"` → `TransactionPaymentContextRecoveryVariant2`

### TransactionPaymentContextRecoveryVariant1

- `type` (`string`, required)

### TransactionPaymentContextRecoveryVariant2

- `type` (`string`, required)
- `attempt` (`int`, required) — Current retry, starting at 1. The original decline is not a retry.
- `maxAttempts` (`int`, required) — Total retries applicable to this charge's dunning schedule.

### TransactionRetry

- `originalTransactionId` (`string`, required)
- `invoiceId` (`string`, required)
- `status` (`string`, required)
- `object` (`string`, required)
- `livemode` (`bool`, required)

### TransactionsListResult

- `object` (`string`, required)
- `data` (`array`, required)
- `hasMore` (`bool`, required)
- `nextCursor` (`string`, optional)

### UpdateCustomerParamsAddress

- `line1` (`string`, required)
- `line2` (`string`, optional)
- `city` (`string`, required)
- `state` (`string`, optional)
- `postalCode` (`string`, required)
- `country` (`string`, required)
- `region` (`string`, optional)

### UpdateOfferParamsPhasesItem

Variants:

- `UpdateOfferParamsPhasesItemVariant1`
- `UpdateOfferParamsPhasesItemVariant2`
- `UpdateOfferParamsPhasesItemVariant3`

Discriminator: `type`

- `"percentage"` → `UpdateOfferParamsPhasesItemVariant1`
- `"amount_off"` → `UpdateOfferParamsPhasesItemVariant2`
- `"fixed_price"` → `UpdateOfferParamsPhasesItemVariant3`

### UpdateOfferParamsPhasesItemVariant1

- `type` (`string`, required)
- `durationCycles` (`int | null`, required)
- `durationInterval` (`string | null`, optional) — Unit the phase duration is counted in. Only a fixed-price phase may set it, because its amount is declared rather than derived from the plan. Defaults to the plan's own billing interval.
- `percentage` (`int`, required) — Discount in basis points. 5000 means 50%.

### UpdateOfferParamsPhasesItemVariant2

- `type` (`string`, required)
- `durationCycles` (`int | null`, required)
- `durationInterval` (`string | null`, optional) — Unit the phase duration is counted in. Only a fixed-price phase may set it, because its amount is declared rather than derived from the plan. Defaults to the plan's own billing interval.
- `amounts` (`array`, required)

### UpdateOfferParamsPhasesItemVariant2AmountsItem

- `currency` (`string`, required)
- `amount` (`int`, required) — Amount in the currency's minor unit (for example, cents for USD).

### UpdateOfferParamsPhasesItemVariant3

- `type` (`string`, required)
- `durationCycles` (`int | null`, required)
- `durationInterval` (`string | null`, optional) — Unit the phase duration is counted in. Only a fixed-price phase may set it, because its amount is declared rather than derived from the plan. Defaults to the plan's own billing interval.
- `prices` (`array`, required)

### UpdateOfferParamsPhasesItemVariant3PricesItem

- `currency` (`string`, required)
- `amount` (`int`, required) — Amount in the currency's minor unit (for example, cents for USD).

### UpdatePlanDraftParamsCountriesItem

- `country` (`string`, required) — ISO country code.
- `currency` (`string`, required) — The currency the country pays in, USD included.
- `exchangeRate` (`float | null`, optional) — Local units per USD for prices that follow the USD base. USD defaults to 1.
- `prices` (`array`, required)
- `topUpMinimum` (`int | null`, optional) — Smallest balance top-up in this country, in the currency's minor unit. Null follows the USD minimum at the exchange rate; left out keeps it.
- `maxPlanBalance` (`int | null`, optional) — Most unused plan balance that rolls over in this country. Null follows the USD cap at the exchange rate; left out keeps it.
- `planBalanceLimit` (`int | null`, optional) — Most plan balance spent per limit interval in this country. Null follows the USD limit at the exchange rate; left out keeps it.
- `addonPrices` (`array`, optional) — What the country pays for each add-on the draft sells. Left out keeps the country's add-on prices; sent, it replaces them, and add-ons not listed follow the USD price.
- `creditPackPrices` (`array`, optional) — What the country pays for each credit pack the draft sells. Left out keeps the country's pack prices; sent, it replaces them, and packs not listed follow the USD price.

### UpdatePlanDraftParamsCountriesItemAddonPricesItem

Variants:

- `UpdatePlanDraftParamsCountriesItemAddonPricesItemVariant1`
- `UpdatePlanDraftParamsCountriesItemAddonPricesItemVariant2`

### UpdatePlanDraftParamsCountriesItemAddonPricesItemVariant1

- `addonId` (`string`, required)
- `price` (`int`, required) — The add-on's price set by hand, in the currency's minor unit.

### UpdatePlanDraftParamsCountriesItemAddonPricesItemVariant2

- `addonId` (`string`, required)
- `followBase` (`mixed`, required) — Follow the add-on's USD price at the exchange rate.

### UpdatePlanDraftParamsCountriesItemCreditPackPricesItem

Variants:

- `UpdatePlanDraftParamsCountriesItemCreditPackPricesItemVariant1`
- `UpdatePlanDraftParamsCountriesItemCreditPackPricesItemVariant2`

### UpdatePlanDraftParamsCountriesItemCreditPackPricesItemVariant1

- `creditPackId` (`string`, required)
- `price` (`int`, required) — The pack's price set by hand, in the currency's minor unit.

### UpdatePlanDraftParamsCountriesItemCreditPackPricesItemVariant2

- `creditPackId` (`string`, required)
- `followBase` (`mixed`, required) — Follow the pack's USD price at the exchange rate.

### UpdatePlanDraftParamsCountriesItemPricesItem

Variants:

- `UpdatePlanDraftParamsCountriesItemPricesItemVariant1`
- `UpdatePlanDraftParamsCountriesItemPricesItemVariant2`

### UpdatePlanDraftParamsCountriesItemPricesItemVariant1

- `billingInterval` (`string`, required)
- `price` (`int`, required) — The price set by hand, in the currency's minor unit.
- `includedBalance` (`int`, optional) — The balance included each period in this country, in the currency's minor unit. Required when the plan's price includes a balance.

### UpdatePlanDraftParamsCountriesItemPricesItemVariant2

- `billingInterval` (`string`, required)
- `followBase` (`mixed`, required) — Follow the USD base at the exchange rate.

### UpdatePlanDraftParamsPricesItem

- `billingInterval` (`string`, required)
- `price` (`int`, required) — USD price in cents.
- `includedCredits` (`int | null`, optional)
- `includedBalance` (`int | null`, optional)
- `trialDays` (`int | null`, optional) — Days of trial on this price. Null removes the trial.
- `trialRequiresPaymentMethod` (`bool`, optional)
- `isDefault` (`bool`, optional) — Show this interval first at checkout and in pricing tables.

### UpdatePlanDraftParamsRules

- `freeIncludedCredits` (`int | null`, optional) — Credits a free plan includes each month.
- `freeIncludedBalance` (`int | null`, optional) — Balance a free plan includes each month, in cents.
- `unusedPlanCredits` (`string`, optional)
- `maxPlanCredits` (`int | null`, optional)
- `planCreditLimit` (`int | null`, optional)
- `planCreditLimitInterval` (`string | null`, optional)
- `unusedPlanBalance` (`string`, optional)
- `maxPlanBalance` (`int | null`, optional)
- `planBalanceLimit` (`int | null`, optional)
- `planBalanceLimitInterval` (`string | null`, optional)
- `blockOnExhaustion` (`bool`, optional)
- `purchasesEnabled` (`bool`, optional)
- `creditPurchaseUnitPrice` (`int | null`, optional)
- `creditPurchaseMinimum` (`int | null`, optional)
- `topUpMinimum` (`int | null`, optional)

### UpdatePlanFeatureParamsOverage

- `enabled` (`bool`, optional)
- `unitPrice` (`int`, optional)

### UpdatePlanParamsPlanBalanceLimit

- `amount` (`int`, required) — The most plan balance a subscription spends in one window, in USD cents. Other currencies convert it with the plan's exchange rate unless the dashboard sets a custom amount for that currency.
- `interval` (`string`, required) — The window length: `day` is 24 hours and `week` is 7 days, starting at the time of day of the subscription's billing anchor.

### UpdatePlanParamsPlanCreditLimit

- `credits` (`int`, required) — The most plan credits a subscription spends in one window.
- `interval` (`string`, required) — The window length: `day` is 24 hours and `week` is 7 days, starting at the time of day of the subscription's billing anchor.

### UpdatePlanParamsUnusedPlanBalance

Variants:

- `UpdatePlanParamsUnusedPlanBalanceVariant1`
- `UpdatePlanParamsUnusedPlanBalanceVariant2`

Discriminator: `type`

- `"expire"` → `UpdatePlanParamsUnusedPlanBalanceVariant1`
- `"roll_over"` → `UpdatePlanParamsUnusedPlanBalanceVariant2`

### UpdatePlanParamsUnusedPlanBalanceVariant1

- `type` (`string`, required)

### UpdatePlanParamsUnusedPlanBalanceVariant2

- `type` (`string`, required)
- `maxPlanBalance` (`int | null`, required) — The most plan balance a subscription holds after a reset, in USD cents, including the balance that reset grants; balance above it expires. At least the included balance of every price. Other currencies convert it with the plan's exchange rate unless the dashboard sets a custom amount for that currency. null means no limit other than the largest storable amount, 2,147,483,647 cents.

### UpdatePlanParamsUnusedPlanCredits

Variants:

- `UpdatePlanParamsUnusedPlanCreditsVariant1`
- `UpdatePlanParamsUnusedPlanCreditsVariant2`

Discriminator: `type`

- `"expire"` → `UpdatePlanParamsUnusedPlanCreditsVariant1`
- `"roll_over"` → `UpdatePlanParamsUnusedPlanCreditsVariant2`

### UpdatePlanParamsUnusedPlanCreditsVariant1

- `type` (`string`, required)

### UpdatePlanParamsUnusedPlanCreditsVariant2

- `type` (`string`, required)
- `maxPlanCredits` (`int | null`, required) — The most plan credits a subscription holds after a reset, including the credits that reset grants; credits above it expire. At least the included credits of every price. null means no limit other than the largest storable balance, 2,147,483,647 plan credits.

### UpdatePlanPriceParamsMarketPricesItem

- `marketGroupId` (`string`, required)
- `currency` (`string`, required)
- `price` (`int`, required)

### UpsertRegionalPricesParamsOverridesItem

- `currency` (`string`, required)
- `price` (`int`, required)
- `includedBalance` (`int`, optional)

### UsageAdjustment

- `id` (`string`, required)
- `value` (`int`, required)
- `previousValue` (`int`, required)
- `adjustment` (`int`, required)
- `customerId` (`string`, required)
- `reason` (`string | null`, required)
- `ts` (`string`, required)
- `createdAt` (`string`, required)
- `featureCode` (`string`, required)
- `object` (`string`, required)
- `livemode` (`bool`, required)

### UsageCheck

Variants:

- `UsageCheckVariant1`
- `UsageCheckVariant2`
- `UsageCheckVariant3`

Discriminator: `consumptionModel`

- `"metered"` → `UsageCheckVariant1`
- `"credits"` → `UsageCheckVariant2`
- `"balance"` → `UsageCheckVariant3`

### UsageCheckVariant1

- `allowed` (`bool`, required)
- `subscriptionStatus` (`string`, required)
- `featureCode` (`string`, required)
- `quantity` (`int`, required)
- `reason` (`string`, optional)
- `message` (`string`, optional)
- `consumptionModel` (`string`, required)
- `current` (`float`, required)
- `remaining` (`float`, required)
- `unlimited` (`bool`, required)
- `included` (`float`, required)
- `overageEnabled` (`bool`, required)
- `overageUnitPrice` (`float | null`, required)
- `object` (`string`, required)
- `livemode` (`bool`, required)

### UsageCheckVariant2

- `allowed` (`bool`, required)
- `subscriptionStatus` (`string`, required)
- `featureCode` (`string`, required)
- `quantity` (`int`, required)
- `reason` (`string`, optional)
- `message` (`string`, optional)
- `consumptionModel` (`string`, required)
- `creditsPerUnit` (`int`, required)
- `estimatedCredits` (`int`, required)
- `planCredits` (`int`, required)
- `purchasedCredits` (`int`, required)
- `totalCredits` (`int`, required)
- `planCreditLimit` (`UsageCheckVariant2PlanCreditLimit | null`, required)
- `blockOnExhaustion` (`bool`, required) — Whether usage stops when plan and purchased credits run out. False only when the plan allows overage, which is billed at its price per credit; trials and free plans always stop.
- `object` (`string`, required)
- `livemode` (`bool`, required)

### UsageCheckVariant2PlanCreditLimit

- `credits` (`int`, required) — The most plan credits the subscription spends per window.
- `interval` (`string`, required) — The window length: 24 hours for `day`, 7 days for `week`.
- `spent` (`int`, required) — Plan credits spent in the current window.
- `remaining` (`int`, required) — Plan credits the subscription can still spend in the current window. Purchased credits are not limited.
- `resetsAt` (`string`, required) — When the next window starts and spending resets.

### UsageCheckVariant3

- `allowed` (`bool`, required)
- `subscriptionStatus` (`string`, required)
- `featureCode` (`string`, required)
- `quantity` (`int`, required)
- `reason` (`string`, optional)
- `message` (`string`, optional)
- `consumptionModel` (`string`, required)
- `unitPrice` (`float`, required)
- `estimatedAmount` (`float`, required)
- `currentBalance` (`float`, required) — The available balance, plan plus purchased, in rate scale (10000 = 1.00 of the subscription currency). Equal to totalBalance.
- `planBalance` (`float`, required) — The plan part of the balance in rate scale. Consumed first, replaced or rolled over at each reset, and negative while overage is owed.
- `purchasedBalance` (`float`, required) — The purchased part of the balance in rate scale: top-ups and adjustments. Consumed after the plan part and kept until the subscription ends.
- `totalBalance` (`float`, required) — planBalance plus purchasedBalance, in rate scale.
- `planBalanceLimit` (`UsageCheckVariant3PlanBalanceLimit | null`, required)
- `blockOnExhaustion` (`bool`, required)
- `currency` (`string`, required)
- `object` (`string`, required)
- `livemode` (`bool`, required)

### UsageCheckVariant3PlanBalanceLimit

- `amount` (`int`, required) — The most plan balance the subscription spends per window, in rate scale (10000 = 1.00 of the subscription currency).
- `interval` (`string`, required) — The window length: 24 hours for `day`, 7 days for `week`.
- `spent` (`int`, required) — Plan balance spent in the current window, in rate scale.
- `remaining` (`int`, required) — Plan balance the subscription can still spend in the current window, in rate scale. Purchased balance is not limited.
- `resetsAt` (`string`, required) — When the next window starts and spending resets.

### UsageEvent

- `id` (`string`, required)
- `featureCode` (`string`, required)
- `value` (`float`, required)
- `customerId` (`string`, required)
- `eventId` (`string | null`, required)
- `ts` (`string`, required)
- `createdAt` (`string`, required)
- `properties` (`array`, required)
- `consumption` (`UsageEventConsumption`, optional)
- `object` (`string`, required)
- `livemode` (`bool`, required)

### UsageEventConsumption

- `model` (`string`, required)
- `deducted` (`float`, required)
- `remaining` (`float`, required)
- `blocked` (`bool`, required)
- `planCreditLimit` (`UsageEventConsumptionPlanCreditLimit | null`, optional) — Credits consumption only, omitted for balance. The plan credit limit after this event; null when the plan has no limit.
- `planBalanceLimit` (`UsageEventConsumptionPlanBalanceLimit | null`, optional) — Balance consumption on a plan with a plan balance limit: the limit after this event. Omitted for credits and for plans without a limit.

### UsageEventConsumptionPlanBalanceLimit

- `amount` (`int`, required) — The most plan balance the subscription spends per window, in rate scale (10000 = 1.00 of the subscription currency).
- `interval` (`string`, required) — The window length: 24 hours for `day`, 7 days for `week`.
- `spent` (`int`, required) — Plan balance spent in the current window, in rate scale.
- `remaining` (`int`, required) — Plan balance the subscription can still spend in the current window, in rate scale. Purchased balance is not limited.
- `resetsAt` (`string`, required) — When the next window starts and spending resets.

### UsageEventConsumptionPlanCreditLimit

- `credits` (`int`, required) — The most plan credits the subscription spends per window.
- `interval` (`string`, required) — The window length: 24 hours for `day`, 7 days for `week`.
- `spent` (`int`, required) — Plan credits spent in the current window.
- `remaining` (`int`, required) — Plan credits the subscription can still spend in the current window. Purchased credits are not limited.
- `resetsAt` (`string`, required) — When the next window starts and spending resets.

### UsageEventPropertiesItem

- `property` (`string`, required)
- `value` (`string`, required)

### UsageQuota

- `featureCode` (`string`, required)
- `current` (`float`, required)
- `included` (`float`, required)
- `remaining` (`float | null`, required)
- `billedQuantity` (`float`, required)
- `unlimited` (`bool`, required)
- `overageEnabled` (`bool`, required)
- `asOf` (`string | null`, required)
- `object` (`string`, required)
- `livemode` (`bool`, required)

### UsageQuotaEvent

- `id` (`string`, required)
- `customerId` (`string`, required)
- `featureCode` (`string`, required)
- `previousBalance` (`int`, required)
- `newBalance` (`int`, required)
- `ts` (`string`, required)
- `createdAt` (`string`, required)
- `object` (`string`, required)
- `livemode` (`bool`, required)

### Webhook

- `id` (`string`, required)
- `url` (`string`, required)
- `events` (`array`, required)
- `description` (`string | null`, required)
- `isActive` (`bool`, required)
- `apiVersion` (`string | null`, required)
- `createdAt` (`string`, required)
- `object` (`string`, required)
- `livemode` (`bool`, required)

### WebhookAddonRef

- `id` (`string`, required)
- `name` (`string`, required)

### WebhookBalance

- `currentBalance` (`float`, required) — The available balance, plan plus purchased, in rate scale. Equal to totalBalance.
- `planBalance` (`float`, required) — The plan part in rate scale: spent first, replaced or rolled over at each reset, negative while overage is owed.
- `purchasedBalance` (`float`, required) — The purchased part in rate scale: top-ups and manual adjustments, spent after the plan part and kept until the subscription ends.
- `totalBalance` (`float`, required) — planBalance plus purchasedBalance, in rate scale.

### WebhookBankRef

- `bankName` (`string | null`, required)
- `last4` (`string`, required)

### WebhookCardInfo

- `brand` (`string`, required)
- `last4` (`string`, required)
- `expMonth` (`float`, required)
- `expYear` (`float`, required)

### WebhookCreditsBalance

- `planCredits` (`float`, required)
- `purchasedCredits` (`float`, required)
- `totalCredits` (`float`, required)

### WebhookPlanGrantTimelineEvent

- `id` (`string`, required) — The public ID of this plan grant event.
- `type` (`string`, required) — The durable lifecycle transition recorded by this event.
- `reason` (`string`, required) — The reason recorded for this transition.
- `source` (`string`, required) — Where this transition originated.
- `previousExpiresAt` (`string | null`, required) — The prior expiration deadline for an update, otherwise null.
- `expiresAt` (`string | null`, required) — The expiration deadline after this transition, if any.
- `duration` (`string | null`, required) — The duration selected by a create or update event.
- `durationCycles` (`int | null`, required) — The selected cycle count when duration is cycles.
- `requestedExpiresAt` (`string | null`, required) — The requested deadline when duration is until_date.
- `createdAt` (`string`, required) — When this transition occurred.

### WebhookPlanRef

- `id` (`string`, required)
- `name` (`string`, required)

### WebhookSeatSummary

- `code` (`string`, required)
- `current` (`float | null`, required)
- `included` (`float | null`, required)
- `remaining` (`float | null`, required)
- `unlimited` (`bool | null`, required)

### WebhooksListResult

- `object` (`string`, required)
- `data` (`array`, required)
- `hasMore` (`bool`, required)
- `nextCursor` (`string`, optional)

### WebhookTest

- `success` (`bool`, required)
- `deliveryId` (`string`, required)
- `deliveredAt` (`string`, required)
- `object` (`string`, required)
- `livemode` (`bool`, required)
