# Addons

API version: `2026-08-27`

## listActive

`$commet->addons->listActive(...)`

`GET /active-addons` · operation `list-active-addons`

List all active add-ons for a customer's subscription.

### Parameters

- `customerId` (`string`, required)

### Returns

`AddonsListActiveResult`

## get

`$commet->addons->get(...)`

`GET /addons/{id}` · operation `get-addon`

Retrieve an add-on by its public ID or slug.

### Parameters

- `id` (`string`, required)

### Returns

`Addon`

## update

`$commet->addons->update(...)`

`PATCH /addons/{id}` · operation `update-addon`

Update an add-on's name, description, pricing, or the plans that sell it.

### Parameters

- `id` (`string`, required)
- `name` (`string`, optional)
- `description` (`string`, optional)
- `basePrice` (`int`, optional)
- `includedUnits` (`int`, optional)
- `overageRate` (`int`, optional)
- `planIds` (`array`, optional) — Plans that sell the add-on, replacing the current ones. Empty means every plan; omitted keeps them. Removing a plan is rejected with addon_has_activations while a subscription of that plan has the add-on active.

### Request options

- `idempotencyKey` (`string`, optional) — Unique key used to safely retry this write for 24 hours without applying it twice.

### Returns

`Addon`

## delete

`$commet->addons->delete(...)`

`DELETE /addons/{id}` · operation `delete-addon`

Soft-delete an add-on. Fails if the add-on has active subscriptions.

### Parameters

- `id` (`string`, required)

### Returns

`DeletedObject`

## list

`$commet->addons->list(...)`

`GET /addons` · operation `list-addons`

List all add-ons with cursor-based pagination.

### Parameters

- `cursor` (`string`, optional)
- `limit` (`int`, optional)

### Returns

`AddonsListResult`

## create

`$commet->addons->create(...)`

`POST /addons` · operation `create-addon`

Create a new add-on linked to a feature. Each feature can only be assigned to one add-on.

### Parameters

- `name` (`string`, required)
- `description` (`string`, optional)
- `basePrice` (`int`, required)
- `featureId` (`string`, required)
- `planIds` (`array`, optional) — Plans that sell the add-on. Omitted or empty, every plan sells it. Plans created later sell it too.
- `consumptionModel` (`string`, required)
- `includedUnits` (`int`, optional)
- `overageRate` (`int`, optional)
- `creditCost` (`int`, optional)

### Valid parameter combinations

- `name` + `basePrice` + `featureId` + `consumptionModel`
- `name` + `basePrice` + `featureId` + `consumptionModel` + `includedUnits` + `overageRate`
- `name` + `basePrice` + `featureId` + `consumptionModel` + `creditCost`
- `name` + `basePrice` + `featureId` + `consumptionModel` + `overageRate`

### Request options

- `idempotencyKey` (`string`, optional) — Unique key used to safely retry this write for 24 hours without applying it twice.

### Returns

`Addon`
