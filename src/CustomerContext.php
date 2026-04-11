<?php

declare(strict_types=1);

namespace Commet;

use Commet\Resources\FeaturesResource;
use Commet\Resources\PortalResource;
use Commet\Resources\SeatsResource;
use Commet\Resources\SubscriptionsResource;
use Commet\Resources\UsageResource;

class CustomerContext
{
    public readonly CustomerFeatures $features;
    public readonly CustomerSeats $seats;
    public readonly CustomerUsage $usage;
    public readonly CustomerSubscription $subscription;
    public readonly CustomerPortal $portal;

    public function __construct(
        private readonly string $customerId,
        FeaturesResource $features,
        SeatsResource $seats,
        UsageResource $usage,
        SubscriptionsResource $subscriptions,
        PortalResource $portal,
    ) {
        $this->features = new CustomerFeatures($customerId, $features);
        $this->seats = new CustomerSeats($customerId, $seats);
        $this->usage = new CustomerUsage($customerId, $usage);
        $this->subscription = new CustomerSubscription($customerId, $subscriptions);
        $this->portal = new CustomerPortal($customerId, $portal);
    }
}

/** @internal */
class CustomerFeatures
{
    public function __construct(
        private readonly string $customerId,
        private readonly FeaturesResource $resource,
    ) {}

    /**
     * @return ApiResponse<\Commet\Models\Feature>
     */
    public function get(string $code): ApiResponse
    {
        return $this->resource->get($code, $this->customerId);
    }

    /**
     * @return ApiResponse<\Commet\Models\FeatureAccess>
     */
    public function check(string $code): ApiResponse
    {
        return $this->resource->check($code, $this->customerId);
    }

    /**
     * @return ApiResponse<\Commet\Models\CanUseResult>
     */
    public function canUse(string $code): ApiResponse
    {
        return $this->resource->canUse($code, $this->customerId);
    }

    /**
     * @return ApiResponse<\Commet\Models\Feature[]>
     */
    public function list(): ApiResponse
    {
        return $this->resource->list($this->customerId);
    }
}

/** @internal */
class CustomerSeats
{
    public function __construct(
        private readonly string $customerId,
        private readonly SeatsResource $resource,
    ) {}

    /**
     * @return ApiResponse<\Commet\Models\SeatEvent>
     */
    public function add(string $seatType, int $count = 1): ApiResponse
    {
        return $this->resource->add($seatType, $count, customerId: $this->customerId);
    }

    /**
     * @return ApiResponse<\Commet\Models\SeatEvent>
     */
    public function remove(string $seatType, int $count = 1): ApiResponse
    {
        return $this->resource->remove($seatType, $count, customerId: $this->customerId);
    }

    /**
     * @return ApiResponse<\Commet\Models\SeatEvent>
     */
    public function set(string $seatType, int $count): ApiResponse
    {
        return $this->resource->set($seatType, $count, customerId: $this->customerId);
    }

    /**
     * @return ApiResponse<\Commet\Models\SeatBalance>
     */
    public function getBalance(string $seatType): ApiResponse
    {
        return $this->resource->getBalance($seatType, customerId: $this->customerId);
    }
}

/** @internal */
class CustomerUsage
{
    public function __construct(
        private readonly string $customerId,
        private readonly UsageResource $resource,
    ) {}

    /**
     * @param array<string, string>|null $properties
     * @return ApiResponse<\Commet\Models\UsageEvent>
     */
    public function track(
        string $feature,
        ?int $value = null,
        ?array $properties = null,
    ): ApiResponse {
        return $this->resource->track(
            feature: $feature,
            customerId: $this->customerId,
            value: $value,
            properties: $properties,
        );
    }
}

/** @internal */
class CustomerSubscription
{
    public function __construct(
        private readonly string $customerId,
        private readonly SubscriptionsResource $resource,
    ) {}

    /**
     * @return ApiResponse<\Commet\Models\Subscription|null>
     */
    public function get(): ApiResponse
    {
        return $this->resource->get($this->customerId);
    }
}

/** @internal */
class CustomerPortal
{
    public function __construct(
        private readonly string $customerId,
        private readonly PortalResource $resource,
    ) {}

    /**
     * @return ApiResponse<\Commet\Models\PortalSession>
     */
    public function getUrl(): ApiResponse
    {
        return $this->resource->getUrl(customerId: $this->customerId);
    }
}
