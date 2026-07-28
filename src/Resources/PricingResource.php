<?php

declare(strict_types=1);

namespace Commet\Resources;

use Commet\HttpClient;
use Commet\Models\DeletedObject;
use Commet\Models\MarketGroup;
use Commet\Models\PricingListMarketGroupsResult;

class PricingResource
{
    public function __construct(
        private readonly HttpClient $http,
    ) {}

    /**
     * Get one reusable pricing market group.
     * @return MarketGroup
     */
    public function getMarketGroup(
        string $id,
    ): MarketGroup {
        $response = $this->http->get(
            "/pricing/market-groups/{$id}",
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid MarketGroup response payload");
        }

        return MarketGroup::fromArray($response->data);
    }

    /**
     * Replace the name, countries, and metadata of a pricing market group.
     * @param string[] $countryCodes
     * @param array<string, mixed>|null $metadata
     * @return MarketGroup
     */
    public function updateMarketGroup(
        string $id,
        string $name,
        array $countryCodes,
        ?array $metadata = null,
        ?string $idempotencyKey = null,
    ): MarketGroup {
        $response = $this->http->patch(
            "/pricing/market-groups/{$id}",
            HttpClient::buildBody([
                "name" => $name,
                "country_codes" => $countryCodes,
                "metadata" => $metadata,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid MarketGroup response payload");
        }

        return MarketGroup::fromArray($response->data);
    }

    /**
     * Delete an unused pricing market group. Groups referenced by prices or subscriptions cannot be deleted.
     * @return DeletedObject
     */
    public function deleteMarketGroup(
        string $id,
    ): DeletedObject {
        $response = $this->http->delete(
            "/pricing/market-groups/{$id}",
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid DeletedObject response payload");
        }

        return DeletedObject::fromArray($response->data);
    }

    /**
     * List reusable country groups used to resolve market-specific prices independently from currency.
     * @return PricingListMarketGroupsResult
     */
    public function listMarketGroups(

    ): PricingListMarketGroupsResult {
        $response = $this->http->get(
            "/pricing/market-groups",
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid PricingListMarketGroupsResult response payload");
        }

        return PricingListMarketGroupsResult::fromArray($response->data);
    }

    /**
     * Create a reusable country group. Countries can belong to only one active group; each price chooses its currency independently.
     * @param string[] $countryCodes
     * @param array<string, mixed>|null $metadata
     * @return MarketGroup
     */
    public function createMarketGroup(
        string $name,
        array $countryCodes,
        ?array $metadata = null,
        ?string $idempotencyKey = null,
    ): MarketGroup {
        $response = $this->http->post(
            "/pricing/market-groups",
            HttpClient::buildBody([
                "name" => $name,
                "country_codes" => $countryCodes,
                "metadata" => $metadata,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid MarketGroup response payload");
        }

        return MarketGroup::fromArray($response->data);
    }
}
