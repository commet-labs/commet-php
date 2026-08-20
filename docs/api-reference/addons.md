# Addons

API version: `2026-07-31`

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

Update an add-on's name, description, or pricing.

### Parameters

- `id` (`string`, required)
- `name` (`string`, optional)
- `description` (`string`, optional)
- `basePrice` (`int`, optional)
- `includedUnits` (`int`, optional)
- `overageRate` (`int`, optional)

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
- `consumptionModel` (`string`, required)
- `includedUnits` (`int`, optional)
- `overageRate` (`int`, optional)
- `creditCost` (`int`, optional)

### Request options

- `idempotencyKey` (`string`, optional) — Unique key used to safely retry this write for 24 hours without applying it twice.

### Returns

`Addon`
