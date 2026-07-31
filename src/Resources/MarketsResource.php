<?php

declare(strict_types=1);

namespace Commet\Resources;

use Commet\HttpClient;
use Commet\Models\DeletedObject;
use Commet\Models\Market;
use Commet\Models\MarketsListResult;

class MarketsResource
{
    public function __construct(
        private readonly HttpClient $http,
    ) {}

    /**
     * Get one reusable market.
     * @return Market
     */
    public function get(
        string $id,
    ): Market {
        $response = $this->http->get(
            "/markets/{$id}",
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid Market response payload");
        }

        return Market::fromArray($response->data);
    }

    /**
     * Replace the name, countries, and metadata of a market.
     * @param string[] $countryCodes
     * @param array<string, mixed>|null $metadata
     * @return Market
     */
    public function update(
        string $id,
        string $name,
        array $countryCodes,
        ?array $metadata = null,
        ?string $idempotencyKey = null,
    ): Market {
        $response = $this->http->patch(
            "/markets/{$id}",
            HttpClient::buildBody([
                "name" => $name,
                "country_codes" => $countryCodes,
                "metadata" => $metadata,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid Market response payload");
        }

        return Market::fromArray($response->data);
    }

    /**
     * Delete an unused market. Markets referenced by prices or subscriptions cannot be deleted.
     * @return DeletedObject
     */
    public function delete(
        string $id,
    ): DeletedObject {
        $response = $this->http->delete(
            "/markets/{$id}",
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid DeletedObject response payload");
        }

        return DeletedObject::fromArray($response->data);
    }

    /**
     * List reusable country groups that resolve market-specific prices independently from currency.
     * @return MarketsListResult
     */
    public function list(

    ): MarketsListResult {
        $response = $this->http->get(
            "/markets",
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid MarketsListResult response payload");
        }

        return MarketsListResult::fromArray($response->data);
    }

    /**
     * Create a reusable market without attaching it to a plan or price. Countries can belong to only one active market.
     * @param string[] $countryCodes
     * @param array<string, mixed>|null $metadata
     * @return Market
     */
    public function create(
        string $name,
        array $countryCodes,
        ?array $metadata = null,
        ?string $idempotencyKey = null,
    ): Market {
        $response = $this->http->post(
            "/markets",
            HttpClient::buildBody([
                "name" => $name,
                "country_codes" => $countryCodes,
                "metadata" => $metadata,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid Market response payload");
        }

        return Market::fromArray($response->data);
    }
}
