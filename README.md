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
$commet->customers->create(email: 'user@example.com', externalId: 'user_123');

// Create a subscription
$commet->subscriptions->create(externalId: 'user_123', planCode: 'pro');

// Track usage
$commet->usage->track(feature: 'api_calls', externalId: 'user_123');

// Track AI token usage
$commet->usage->track(
    feature: 'ai_generation',
    externalId: 'user_123',
    model: 'claude-sonnet-4-20250514',
    inputTokens: 1000,
    outputTokens: 500,
);
```

## Customer context

Scope all operations to a customer to avoid repeating `externalId`:

```php
$customer = $commet->customer('user_123');

$customer->usage->track('api_calls');
$customer->features->check('custom_branding');
$customer->seats->add('editor', count: 3);
$customer->portal->getUrl();
```

## Webhook verification

```php
use Commet\Webhooks;

$webhooks = new Webhooks();

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
