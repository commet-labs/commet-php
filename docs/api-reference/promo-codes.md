# Promo Codes

API version: `2026-07-31`

## get

`$commet->promoCodes->get(...)`

`GET /promo-codes/{id}` · operation `get-promo-code`

Retrieve a promo code by its public ID.

### Parameters

- `id` (`string`, required)

### Returns

`PromoCode`

## update

`$commet->promoCodes->update(...)`

`PATCH /promo-codes/{id}` · operation `update-promo-code`

Update a promo code's billing interval, redemption limits, expiration, active status, or plan restrictions.

### Parameters

- `id` (`string`, required)
- `billingInterval` (`string | null`, optional)
- `maxRedemptions` (`int | null`, optional)
- `expiresAt` (`string | null`, optional)
- `active` (`bool`, optional)
- `planIds` (`array`, optional)

### Request options

- `idempotencyKey` (`string`, optional) — Unique key used to safely retry this write for 24 hours without applying it twice.

### Returns

`PromoCode`

## list

`$commet->promoCodes->list(...)`

`GET /promo-codes` · operation `list-promo-codes`

List promo codes with cursor-based pagination.

### Parameters

- `cursor` (`string`, optional)
- `limit` (`int`, optional)

### Returns

`PromoCodesListResult`

## create

`$commet->promoCodes->create(...)`

`POST /promo-codes` · operation `create-promo-code`

Create a distribution code for an existing Offer. The referenced Offer owns the benefit and duration; the promo code owns redemption restrictions.

### Parameters

- `code` (`string`, required)
- `offerId` (`string`, required)
- `billingInterval` (`string | null`, optional)
- `maxRedemptions` (`int`, optional)
- `expiresAt` (`string`, optional)
- `planIds` (`array`, optional)

### Request options

- `idempotencyKey` (`string`, optional) — Unique key used to safely retry this write for 24 hours without applying it twice.

### Returns

`PromoCode`
