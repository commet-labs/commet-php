<?php

declare(strict_types=1);

namespace Commet;

use Commet\Resources\UsageResource;
use Commet\Resources\WebhooksResource;

class Commet
{
    use GeneratedResources;

    public readonly UsageResource $usage;
    public readonly WebhooksResource $webhooks;

    public function __construct(
        string $apiKey,
        string $apiVersion = HttpClient::API_VERSION,
        float $timeout = 30.0,
        int $retries = 3,
        bool $telemetry = true,
        bool $debug = false,
    ) {
        if ($apiKey === '') {
            throw new \InvalidArgumentException('Commet SDK: API key is required');
        }

        if (!str_starts_with($apiKey, 'ck_')) {
            throw new \InvalidArgumentException('Commet SDK: Invalid API key format. Expected format: ck_xxx...');
        }

        $http = new HttpClient($apiKey, $apiVersion, $timeout, $retries, $telemetry, $debug);

        $this->initResources($http);

        $this->usage = new UsageResource($http);
        $this->webhooks = new WebhooksResource($http);
    }
}
