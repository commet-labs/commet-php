# Commet PHP SDK

Billing and usage tracking for SaaS applications.

## Installation

```bash
composer require commet/commet-php
```

## Quick start

```php
use Commet\Commet;

$commet = new Commet(apiKey: 'ck_xxx');

// Create a customer
$customer = $commet->customers->create(email: 'user@example.com');

// Create a subscription
$commet->subscriptions->create(customerId: $customer->id, planCode: 'pro');

// Track usage
$commet->usage->track(
    featureCode: 'api_calls',
    customerId: $customer->id,
    value: 1,
);

// Track AI token usage
$commet->usage->track(
    featureCode: 'ai_generation',
    customerId: $customer->id,
    model: 'claude-sonnet-4-20250514',
    inputTokens: 1000,
    outputTokens: 500,
);
```

## Quota

Track consumption against a fixed allowance:

```php
$commet->quota->add(featureCode: 'tasks', count: 3, customerId: 'user_123');
$commet->quota->set(featureCode: 'tasks', count: 10, customerId: 'user_123');
$commet->quota->remove(featureCode: 'tasks', count: 1, customerId: 'user_123');

$allowance = $commet->quota->get(featureCode: 'tasks', customerId: 'user_123');

$allowances = $commet->quota->getAll(customerId: 'user_123');
```

## Webhook verification

```php
use Commet\Resources\WebhooksResource;

$webhooks = new WebhooksResource();

$payload = $webhooks->verifyAndParse(
    rawBody: $requestBody,
    signature: $_SERVER['HTTP_X_COMMET_SIGNATURE'] ?? null,
    secret: 'whsec_xxx',
);

if ($payload === null) {
    throw new \RuntimeException('Invalid webhook signature');
}

if ($payload['event'] === 'subscription.activated') {
    // handle activation
}
```

## License

MIT
