<?php

declare(strict_types=1);

namespace Commet\Resources;

use Commet\HttpClient;

class WebhooksResource extends GeneratedWebhooksResource
{
    public function __construct(
        ?HttpClient $http = null,
    ) {
        if ($http !== null) {
            parent::__construct($http);
        }
    }

    public function verify(string $payload, ?string $signature, string $secret): bool
    {
        if ($signature === null || $signature === '' || $secret === '' || $payload === '') {
            return false;
        }

        $expected = hash_hmac('sha256', $payload, $secret);

        return hash_equals($expected, $signature);
    }

    /**
     * @return array<string, mixed>|null
     */
    public function verifyAndParse(string $rawBody, ?string $signature, string $secret): ?array
    {
        if (!$this->verify($rawBody, $signature, $secret)) {
            return null;
        }

        try {
            $parsed = json_decode($rawBody, true, 512, JSON_THROW_ON_ERROR);
            return is_array($parsed) ? $parsed : null;
        } catch (\JsonException) {
            return null;
        }
    }

}
