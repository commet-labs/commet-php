<?php

declare(strict_types=1);

namespace Commet\Resources;

use Commet\HttpClient;
use Commet\Models\CreditPack;
use Commet\Models\CreditPacksListResult;
use Commet\Models\DeletedObject;

class CreditPacksResource
{
    public function __construct(
        private readonly HttpClient $http,
    ) {}

    /**
     * Update a credit pack's name, description, credits, price, or active status.
     * @return CreditPack
     */
    public function update(
        string $id,
        ?string $name = null,
        ?string $description = null,
        ?int $credits = null,
        ?int $price = null,
        ?bool $isActive = null,
        ?string $idempotencyKey = null,
    ): CreditPack {
        $response = $this->http->patch(
            "/credit-packs/{$id}",
            HttpClient::buildBody([
                "name" => $name,
                "description" => $description,
                "credits" => $credits,
                "price" => $price,
                "is_active" => $isActive,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid CreditPack response payload");
        }

        return CreditPack::fromArray($response->data);
    }

    /**
     * Soft-delete a credit pack.
     * @return DeletedObject
     */
    public function delete(
        string $id,
    ): DeletedObject {
        $response = $this->http->delete(
            "/credit-packs/{$id}",
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid DeletedObject response payload");
        }

        return DeletedObject::fromArray($response->data);
    }

    /**
     * List all active credit packs.
     * @return CreditPacksListResult
     */
    public function list(

    ): CreditPacksListResult {
        $response = $this->http->get(
            "/credit-packs",
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid CreditPacksListResult response payload");
        }

        return CreditPacksListResult::fromArray($response->data);
    }

    /**
     * Create a new credit pack.
     * @return CreditPack
     */
    public function create(
        string $name,
        int $credits,
        int $price,
        ?string $description = null,
        ?bool $isActive = null,
        ?string $idempotencyKey = null,
    ): CreditPack {
        $response = $this->http->post(
            "/credit-packs",
            HttpClient::buildBody([
                "name" => $name,
                "description" => $description,
                "credits" => $credits,
                "price" => $price,
                "is_active" => $isActive,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid CreditPack response payload");
        }

        return CreditPack::fromArray($response->data);
    }
}
