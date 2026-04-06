<?php

declare(strict_types=1);

namespace Commet;

use Commet\Resources\CreditPacksResource;
use Commet\Resources\CustomersResource;
use Commet\Resources\FeaturesResource;
use Commet\Resources\PlansResource;
use Commet\Resources\PortalResource;
use Commet\Resources\SeatsResource;
use Commet\Resources\SubscriptionsResource;
use Commet\Resources\UsageResource;

class Commet
{
    private const VALID_ENVIRONMENTS = ['sandbox', 'production'];

    public readonly CustomersResource $customers;
    public readonly PlansResource $plans;
    public readonly SubscriptionsResource $subscriptions;
    public readonly UsageResource $usage;
    public readonly SeatsResource $seats;
    public readonly FeaturesResource $features;
    public readonly PortalResource $portal;
    public readonly CreditPacksResource $creditPacks;
    public readonly Webhooks $webhooks;

    private string $environment;

    public function __construct(
        string $apiKey,
        string $environment = 'sandbox',
        float $timeout = 30.0,
        int $retries = 3,
    ) {
        if ($apiKey === '') {
            throw new \InvalidArgumentException('Commet SDK: API key is required');
        }

        if (!str_starts_with($apiKey, 'ck_')) {
            throw new \InvalidArgumentException('Commet SDK: Invalid API key format. Expected format: ck_xxx...');
        }

        if (!in_array($environment, self::VALID_ENVIRONMENTS, true)) {
            throw new \InvalidArgumentException(
                "Commet SDK: Invalid environment '{$environment}'. Must be 'sandbox' or 'production'"
            );
        }

        $this->environment = $environment;

        $http = new HttpClient($apiKey, $environment, $timeout, $retries);

        $this->customers = new CustomersResource($http);
        $this->plans = new PlansResource($http);
        $this->subscriptions = new SubscriptionsResource($http);
        $this->usage = new UsageResource($http);
        $this->seats = new SeatsResource($http);
        $this->features = new FeaturesResource($http);
        $this->portal = new PortalResource($http);
        $this->creditPacks = new CreditPacksResource($http);
        $this->webhooks = new Webhooks();
    }

    public function customer(string $externalId): CustomerContext
    {
        return new CustomerContext(
            $externalId,
            features: $this->features,
            seats: $this->seats,
            usage: $this->usage,
            subscriptions: $this->subscriptions,
            portal: $this->portal,
        );
    }

    public function getEnvironment(): string
    {
        return $this->environment;
    }

    public function isSandbox(): bool
    {
        return $this->environment === 'sandbox';
    }

    public function isProduction(): bool
    {
        return $this->environment === 'production';
    }
}
