<?php

declare(strict_types=1);

namespace Commet\Resources;

use Commet\HttpClient;
use Commet\Models\FeatureAccess;
use Commet\Models\FeatureAccessListResult;

class FeatureAccessResource
{
    public function __construct(
        private readonly HttpClient $http,
    ) {}

    /**
     * Get one feature's access and current usage for a customer. To evaluate a prospective consumption, use POST /usage/check.
     * @return FeatureAccess
     */
    public function get(
        string $code,
        string $customerId,
    ): FeatureAccess {
        $response = $this->http->get(
            "/feature-access/{$code}",
            HttpClient::buildBody([
                "customer_id" => $customerId,
            ]),
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid FeatureAccess response payload");
        }

        return FeatureAccess::fromArray($response->data);
    }

    /**
     * List a customer's feature access and current usage.
     * @return FeatureAccessListResult
     */
    public function list(
        string $customerId,
    ): FeatureAccessListResult {
        $response = $this->http->get(
            "/feature-access",
            HttpClient::buildBody([
                "customer_id" => $customerId,
            ]),
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid FeatureAccessListResult response payload");
        }

        return FeatureAccessListResult::fromArray($response->data);
    }
}
