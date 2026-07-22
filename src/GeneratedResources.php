<?php

declare(strict_types=1);

namespace Commet;

use Commet\Resources\AddonsResource;
use Commet\Resources\ApiKeysResource;
use Commet\Resources\CreditPacksResource;
use Commet\Resources\CustomersResource;
use Commet\Resources\FeatureAccessResource;
use Commet\Resources\FeaturesResource;
use Commet\Resources\InvoicesResource;
use Commet\Resources\PaymentsResource;
use Commet\Resources\PayoutsResource;
use Commet\Resources\PlanGroupsResource;
use Commet\Resources\PlansResource;
use Commet\Resources\PortalResource;
use Commet\Resources\PromoCodesResource;
use Commet\Resources\ProvisioningResource;
use Commet\Resources\QuotaResource;
use Commet\Resources\SeatsResource;
use Commet\Resources\SubscriptionsResource;
use Commet\Resources\TestClockResource;
use Commet\Resources\TransactionsResource;

trait GeneratedResources
{
    public AddonsResource $addons;
    public ApiKeysResource $apiKeys;
    public CreditPacksResource $creditPacks;
    public CustomersResource $customers;
    public FeatureAccessResource $featureAccess;
    public FeaturesResource $features;
    public InvoicesResource $invoices;
    public PaymentsResource $payments;
    public PayoutsResource $payouts;
    public PlanGroupsResource $planGroups;
    public PlansResource $plans;
    public PortalResource $portal;
    public PromoCodesResource $promoCodes;
    public ProvisioningResource $provisioning;
    public QuotaResource $quota;
    public SeatsResource $seats;
    public SubscriptionsResource $subscriptions;
    public TestClockResource $testClock;
    public TransactionsResource $transactions;

    private function initResources(HttpClient $http): void
    {
        $this->addons = new AddonsResource($http);
        $this->apiKeys = new ApiKeysResource($http);
        $this->creditPacks = new CreditPacksResource($http);
        $this->customers = new CustomersResource($http);
        $this->featureAccess = new FeatureAccessResource($http);
        $this->features = new FeaturesResource($http);
        $this->invoices = new InvoicesResource($http);
        $this->payments = new PaymentsResource($http);
        $this->payouts = new PayoutsResource($http);
        $this->planGroups = new PlanGroupsResource($http);
        $this->plans = new PlansResource($http);
        $this->portal = new PortalResource($http);
        $this->promoCodes = new PromoCodesResource($http);
        $this->provisioning = new ProvisioningResource($http);
        $this->quota = new QuotaResource($http);
        $this->seats = new SeatsResource($http);
        $this->subscriptions = new SubscriptionsResource($http);
        $this->testClock = new TestClockResource($http);
        $this->transactions = new TransactionsResource($http);
    }
}
