# Getting started

Install the SDK:

```bash
composer require commet/commet-php:9.3.0
```

Create one server-side client. Never expose an API key to browser code.

```php
use Commet\Commet;

$commet = new Commet(apiKey: 'ck_xxx');
```

Every resource and method in this release is generated from the versioned OpenAPI contract. Use the installed API reference instead of relying on remembered method names.
