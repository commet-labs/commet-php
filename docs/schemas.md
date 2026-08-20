# Schemas

Generated from Commet API version `2026-07-31`.

## Enums

### BillingInterval

- `"weekly"`
- `"monthly"`
- `"quarterly"`
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

### PaymentProvider

- `"stripe"`
- `"commet"`
- `"dlocal"`

### SubscriptionStatus

- `"draft"`
- `"pending_payment"`
- `"trialing"`
- `"active"`
- `"past_due"`
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

### ClaimLink

- `url` (`string`, required)
- `expiresAt` (`string`, required)
- `object` (`string`, required)
- `livemode` (`bool`, required)

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
- `createdAt` (`string`, required)
- `updatedAt` (`string`, required)
- `offerApplications` (`array`, required)
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

### CreatedSubscriptionPlan

- `id` (`string`, required)
- `name` (`string`, required)

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
- `CreateOfferParamsPhasesItemVariant4`

### CreateOfferParamsPhasesItemVariant1

- `type` (`string`, required)
- `durationDays` (`int`, required)

### CreateOfferParamsPhasesItemVariant2

- `type` (`string`, required)
- `durationCycles` (`int | null`, required)
- `durationInterval` (`string | null`, optional) — Unit the phase duration is counted in. Only a fixed-price phase may set it, because its amount is declared rather than derived from the plan. Defaults to the plan's own billing interval.
- `percentage` (`int`, required) — Discount in basis points. 5000 means 50%.

### CreateOfferParamsPhasesItemVariant3

- `type` (`string`, required)
- `durationCycles` (`int | null`, required)
- `durationInterval` (`string | null`, optional) — Unit the phase duration is counted in. Only a fixed-price phase may set it, because its amount is declared rather than derived from the plan. Defaults to the plan's own billing interval.
- `amounts` (`array`, required)

### CreateOfferParamsPhasesItemVariant3AmountsItem

- `currency` (`string`, required)
- `amount` (`int`, required) — Amount in the currency's minor unit (for example, cents for USD).

### CreateOfferParamsPhasesItemVariant4

- `type` (`string`, required)
- `durationCycles` (`int | null`, required)
- `durationInterval` (`string | null`, optional) — Unit the phase duration is counted in. Only a fixed-price phase may set it, because its amount is declared rather than derived from the plan. Defaults to the plan's own billing interval.
- `prices` (`array`, required)

### CreateOfferParamsPhasesItemVariant4PricesItem

- `currency` (`string`, required)
- `amount` (`int`, required) — Amount in the currency's minor unit (for example, cents for USD).

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
- `createdAt` (`string`, required)
- `updatedAt` (`string`, required)
- `object` (`string`, required)
- `livemode` (`bool`, required)

### OfferPhasesItem

Variants:

- `OfferPhasesItemVariant1`
- `OfferPhasesItemVariant2`
- `OfferPhasesItemVariant3`
- `OfferPhasesItemVariant4`

### OfferPhasesItemVariant1

- `type` (`string`, required)
- `durationDays` (`int`, required)

### OfferPhasesItemVariant2

- `type` (`string`, required)
- `durationCycles` (`int | null`, required)
- `durationInterval` (`string | null`, required) — Unit the phase duration is counted in. Only a fixed-price phase may set it, because its amount is declared rather than derived from the plan. Defaults to the plan's own billing interval.
- `percentage` (`int`, required) — Discount in basis points. 5000 means 50%.

### OfferPhasesItemVariant3

- `type` (`string`, required)
- `durationCycles` (`int | null`, required)
- `durationInterval` (`string | null`, required) — Unit the phase duration is counted in. Only a fixed-price phase may set it, because its amount is declared rather than derived from the plan. Defaults to the plan's own billing interval.
- `amounts` (`array`, required)

### OfferPhasesItemVariant3AmountsItem

- `currency` (`string`, required)
- `amount` (`int`, required) — Amount in the currency's minor unit (for example, cents for USD).

### OfferPhasesItemVariant4

- `type` (`string`, required)
- `durationCycles` (`int | null`, required)
- `durationInterval` (`string | null`, required) — Unit the phase duration is counted in. Only a fixed-price phase may set it, because its amount is declared rather than derived from the plan. Defaults to the plan's own billing interval.
- `prices` (`array`, required)

### OfferPhasesItemVariant4PricesItem

- `currency` (`string`, required)
- `amount` (`int`, required) — Amount in the currency's minor unit (for example, cents for USD).

### OffersListResult

- `object` (`string`, required)
- `data` (`array`, required)
- `hasMore` (`bool`, required)
- `nextCursor` (`string`, optional)

### Payment

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
- `blockOnExhaustion` (`bool | null`, required)
- `sortOrder` (`int`, required)
- `planGroupId` (`string | null`, required)
- `metadata` (`array | null`, required)
- `createdAt` (`string`, required)
- `updatedAt` (`string`, required)
- `features` (`array`, required)
- `prices` (`array`, required)
- `exchangeRates` (`array`, required)
- `object` (`string`, required)
- `livemode` (`bool`, required)

### PlanChange

Variants:

- `PlanChangeVariant1`
- `PlanChangeVariant2`
- `PlanChangeVariant3`

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

### PlanExchangeRatesItem

- `currency` (`string`, required)
- `exchangeRate` (`float`, required)

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

### PlanPrice

- `id` (`string`, required) — Public plan price ID.
- `planId` (`string`, required)
- `billingInterval` (`BillingInterval`, required)
- `price` (`int`, required) — Price in the currency's minor unit (for example, cents for USD).
- `isDefault` (`bool`, required)
- `trialDays` (`int`, required)
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

### PlansListResult

- `object` (`string`, required)
- `data` (`array`, required)
- `hasMore` (`bool`, required)
- `nextCursor` (`string`, optional)

### PortalAccess

- `portalUrl` (`string`, required)
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
- `offerApplication` (`PreviewChangeOfferApplication`, optional)
- `object` (`string`, required)
- `livemode` (`bool`, required)

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
- `createdAt` (`string`, required)
- `updatedAt` (`string`, required)
- `object` (`string`, required)
- `livemode` (`bool`, required)

### PromoCodesListResult

- `object` (`string`, required)
- `data` (`array`, required)
- `hasMore` (`bool`, required)
- `nextCursor` (`string`, optional)

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
- `createdAt` (`string`, required)
- `updatedAt` (`string`, required)
- `offerApplications` (`array`, required)
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

### SubscriptionBalance

- `remaining` (`float`, required)
- `included` (`float`, required)
- `currency` (`string`, required)

### SubscriptionCancellation

- `scheduledAt` (`string`, required)
- `reason` (`string | null`, required)
- `effectiveAt` (`string`, required)

### SubscriptionCredits

- `remaining` (`float`, required)
- `included` (`float`, required)
- `purchased` (`float`, required)

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

### SubscriptionScheduledPlanChange

- `changeType` (`string`, required)
- `newPlanId` (`string | null`, required)
- `newPlanName` (`string | null`, required)
- `newBillingInterval` (`string | null`, required)
- `scheduledFor` (`string`, required)

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
- `createdAt` (`string`, required)
- `updatedAt` (`string`, required)
- `offerApplications` (`array`, required)
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

### SubscriptionSummaryPlan

- `id` (`string`, required)
- `name` (`string`, required)

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

- `id` (`string`, required)
- `invoiceId` (`string | null`, required)
- `grossAmount` (`int | null`, required) — Gross amount in USD cents. Null when the provider has not reported an honest USD figure; see presentmentAmount.
- `subtotal` (`int | null`, required) — Subtotal in USD cents (gross minus tax). Null when grossAmount is null.
- `taxAmount` (`int | null`, required)
- `presentmentAmount` (`int | null`, required) — Amount in the charge currency's smallest unit, as presented to the customer. Set for non-USD charges; null when the charge was made in USD.
- `currency` (`string`, required)
- `provider` (`PaymentProvider`, required) — The payment provider the charge was routed to: stripe, commet, or dlocal.
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

- `id` (`string`, required)
- `invoiceId` (`string | null`, required)
- `grossAmount` (`int | null`, required) — Gross amount in USD cents. Null when the provider has not reported an honest USD figure; see presentmentAmount.
- `subtotal` (`int | null`, required) — Subtotal in USD cents (gross minus tax). Null when grossAmount is null.
- `taxAmount` (`int | null`, required)
- `presentmentAmount` (`int | null`, required) — Amount in the charge currency's smallest unit, as presented to the customer. Set for non-USD charges; null when the charge was made in USD.
- `currency` (`string`, required)
- `provider` (`PaymentProvider`, required) — The payment provider the charge was routed to: stripe, commet, or dlocal.
- `status` (`TransactionStatus`, required)
- `customerEmail` (`string | null`, required)
- `customerName` (`string | null`, required)
- `paidAt` (`string | null`, required)
- `createdAt` (`string`, required)
- `updatedAt` (`string`, required)
- `object` (`string`, required)
- `livemode` (`bool`, required)

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
- `UpdateOfferParamsPhasesItemVariant4`

### UpdateOfferParamsPhasesItemVariant1

- `type` (`string`, required)
- `durationDays` (`int`, required)

### UpdateOfferParamsPhasesItemVariant2

- `type` (`string`, required)
- `durationCycles` (`int | null`, required)
- `durationInterval` (`string | null`, optional) — Unit the phase duration is counted in. Only a fixed-price phase may set it, because its amount is declared rather than derived from the plan. Defaults to the plan's own billing interval.
- `percentage` (`int`, required) — Discount in basis points. 5000 means 50%.

### UpdateOfferParamsPhasesItemVariant3

- `type` (`string`, required)
- `durationCycles` (`int | null`, required)
- `durationInterval` (`string | null`, optional) — Unit the phase duration is counted in. Only a fixed-price phase may set it, because its amount is declared rather than derived from the plan. Defaults to the plan's own billing interval.
- `amounts` (`array`, required)

### UpdateOfferParamsPhasesItemVariant3AmountsItem

- `currency` (`string`, required)
- `amount` (`int`, required) — Amount in the currency's minor unit (for example, cents for USD).

### UpdateOfferParamsPhasesItemVariant4

- `type` (`string`, required)
- `durationCycles` (`int | null`, required)
- `durationInterval` (`string | null`, optional) — Unit the phase duration is counted in. Only a fixed-price phase may set it, because its amount is declared rather than derived from the plan. Defaults to the plan's own billing interval.
- `prices` (`array`, required)

### UpdateOfferParamsPhasesItemVariant4PricesItem

- `currency` (`string`, required)
- `amount` (`int`, required) — Amount in the currency's minor unit (for example, cents for USD).

### UpdatePlanFeatureParamsOverage

- `enabled` (`bool`, optional)
- `unitPrice` (`int`, optional)

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
- `object` (`string`, required)
- `livemode` (`bool`, required)

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
- `currentBalance` (`float`, required)
- `blockOnExhaustion` (`bool`, required)
- `currency` (`string`, required)
- `object` (`string`, required)
- `livemode` (`bool`, required)

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

- `currentBalance` (`float`, required)

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
