# Errors and request IDs

```php
try {
    $commet->customers->get(id: 'cus_123');
} catch (ApiException $error) {
    echo $error->errorCode;
    echo $error->requestId;
    echo $error->docUrl;
}
```

API errors expose type, code, message, status, parameter, details, the exact server request ID, and a versioned documentation URL. The installed error reference describes retry behavior. A request ID is absent when Platform did not return one and is never fabricated locally.

Preserve the same idempotency key when retrying an allowed write.
