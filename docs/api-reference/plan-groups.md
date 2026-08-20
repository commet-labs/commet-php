# Plan Groups

API version: `2026-07-31`

## removePlan

`$commet->planGroups->removePlan(...)`

`DELETE /plan-groups/{id}/plans/{planId}` · operation `remove-plan-from-group`

Remove a plan from a plan group.

### Parameters

- `id` (`string`, required)
- `planId` (`string`, required)

### Returns

`RemovedPlanFromGroup`

## reorderPlans

`$commet->planGroups->reorderPlans(...)`

`PUT /plan-groups/{id}/plans/reorder` · operation `reorder-plans-in-group`

Set the display order of plans within a group. All plan IDs in the group must be provided.

### Parameters

- `id` (`string`, required)
- `planIds` (`array`, required)

### Request options

- `idempotencyKey` (`string`, optional) — Unique key used to safely retry this write for 24 hours without applying it twice.

### Returns

`ReorderedPlans`

## addPlan

`$commet->planGroups->addPlan(...)`

`POST /plan-groups/{id}/plans` · operation `add-plan-to-group`

Add an existing plan to a plan group with optional sort order.

### Parameters

- `id` (`string`, required)
- `planId` (`string`, required)
- `sortOrder` (`int`, optional)

### Request options

- `idempotencyKey` (`string`, optional) — Unique key used to safely retry this write for 24 hours without applying it twice.

### Returns

`AddedPlanToGroup`

## get

`$commet->planGroups->get(...)`

`GET /plan-groups/{id}` · operation `get-plan-group`

Retrieve a plan group by ID, including its plans ordered by sortOrder.

### Parameters

- `id` (`string`, required)

### Returns

`PlanGroupDetail`

## update

`$commet->planGroups->update(...)`

`PATCH /plan-groups/{id}` · operation `update-plan-group`

Update a plan group's name, description, or visibility.

### Parameters

- `id` (`string`, required)
- `name` (`string`, optional)
- `description` (`string | null`, optional)
- `isPublic` (`bool`, optional)

### Request options

- `idempotencyKey` (`string`, optional) — Unique key used to safely retry this write for 24 hours without applying it twice.

### Returns

`PlanGroup`

## delete

`$commet->planGroups->delete(...)`

`DELETE /plan-groups/{id}` · operation `delete-plan-group`

Delete a plan group. Plans in the group are unlinked, not deleted.

### Parameters

- `id` (`string`, required)

### Returns

`DeletedObject`

## list

`$commet->planGroups->list(...)`

`GET /plan-groups` · operation `list-plan-groups`

List plan groups with cursor-based pagination.

### Parameters

- `cursor` (`string`, optional)
- `limit` (`int`, optional)

### Returns

`PlanGroupsListResult`

## create

`$commet->planGroups->create(...)`

`POST /plan-groups` · operation `create-plan-group`

Create a new plan group for organizing plans.

### Parameters

- `name` (`string`, required)
- `description` (`string`, optional)
- `isPublic` (`bool`, optional)

### Request options

- `idempotencyKey` (`string`, optional) — Unique key used to safely retry this write for 24 hours without applying it twice.

### Returns

`PlanGroup`
