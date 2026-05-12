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
    public readonly CustomersResource $customers;
    public readonly PlansResource $plans;
    public readonly SubscriptionsResource $subscriptions;
    public readonly UsageResource $usage;
    public readonly SeatsResource $seats;
    public readonly FeaturesResource $features;
    public readonly PortalResource $portal;
    public readonly CreditPacksResource $creditPacks;
    public readonly Webhooks $webhooks;

    public function __construct(
        string $apiKey,
        string $apiVersion = HttpClient::API_VERSION,
        float $timeout = 30.0,
        int $retries = 3,
    ) {
        if ($apiKey === '') {
            throw new \InvalidArgumentException('Commet SDK: API key is required');
        }

        if (!str_starts_with($apiKey, 'ck_')) {
            throw new \InvalidArgumentException('Commet SDK: Invalid API key format. Expected format: ck_xxx...');
        }

        $http = new HttpClient($apiKey, $apiVersion, $timeout, $retries);

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

    public function customer(string $customerId): CustomerContext
    {
        return new CustomerContext(
            $customerId,
            features: $this->features,
            seats: $this->seats,
            usage: $this->usage,
            subscriptions: $this->subscriptions,
            portal: $this->portal,
        );
    }
}
