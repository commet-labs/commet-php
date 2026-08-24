# Payments

API version: `2026-07-31`

## cancel

`$commet->payments->cancel(...)`

`POST /payments/{id}/cancel` · operation `cancel-payment`

Cancel a pending payment link so it can no longer be paid. Only a link that has not been paid or started processing can be canceled; canceling an already canceled link is a no-op. Charges cannot be canceled.

### Parameters

- `id` (`string`, required)

### Request options

- `idempotencyKey` (`string`, optional) — Unique key used to safely retry this write for 24 hours without applying it twice.

### Returns

`Payment`

## get

`$commet->payments->get(...)`

`GET /payments/{id}` · operation `get-payment`

Retrieve a payment by its public ID.

### Parameters

- `id` (`string`, required)

### Returns

`Payment`

## charge

`$commet->payments->charge(...)`

`POST /payments/charge` · operation `charge-payment`

Charge a customer's vaulted payment method off-session. Calculates tax, generates an invoice, and sends a receipt. Requires the customer to have a subscription in active, trialing, or past_due state.

### Parameters

- `customerId` (`string`, required)
- `amount` (`int`, required)
- `currency` (`string`, required)
- `description` (`string`, required)
- `metadata` (`array`, optional)

### Request options

- `idempotencyKey` (`string`, optional) — Unique key used to safely retry this write for 24 hours without applying it twice.

### Returns

`Payment`

## list

`$commet->payments->list(...)`

`GET /payments` · operation `list-payments`

List payments with cursor-based pagination. Filter by customer.

### Parameters

- `cursor` (`string`, optional)
- `limit` (`int`, optional)
- `customerId` (`string`, optional)

### Returns

`PaymentsListResult`

## create

`$commet->payments->create(...)`

`POST /payments` · operation `create-payment`

Create a hosted payment link. Returns a url the customer opens to pay with any card. Calculates tax, generates an invoice, and vaults the payment method on confirmation. No subscription or plan required.

### Parameters

- `amount` (`int`, required)
- `currency` (`string`, required)
- `customerId` (`string`, optional)
- `description` (`string`, required)
- `successUrl` (`string`, optional)
- `metadata` (`array`, optional)

### Request options

- `idempotencyKey` (`string`, optional) — Unique key used to safely retry this write for 24 hours without applying it twice.

### Returns

`Payment`
