<?php

declare(strict_types=1);

namespace Commet\Resources;

use Commet\HttpClient;
use Commet\Models\CreateOfferParamsPhasesItem;
use Commet\Models\DeletedOffer;
use Commet\Models\Offer;
use Commet\Models\OffersListResult;
use Commet\Models\UpdateOfferParamsPhasesItem;

class OffersResource
{
    public function __construct(
        private readonly HttpClient $http,
    ) {}

    /**
     * Retrieve a canonical offer by its public ID.
     * @return Offer
     */
    public function get(
        string $id,
    ): Offer {
        $response = $this->http->get(
            "/offers/{$id}",
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid Offer response payload");
        }

        return Offer::fromArray($response->data);
    }

    /**
     * Replace an offer's catalog definition. Existing offer applications keep their immutable accepted terms.
     * @param string[] $planPriceIds
     * @param UpdateOfferParamsPhasesItem[] $phases
     * @param array<string, mixed>|null $metadata
     * @return Offer
     */
    public function update(
        string $id,
        string $name,
        string $purpose,
        array $planPriceIds,
        array $phases,
        ?array $metadata = null,
        ?string $startsAt = null,
        ?string $endsAt = null,
        ?bool $active = null,
        ?string $idempotencyKey = null,
    ): Offer {
        $response = $this->http->patch(
            "/offers/{$id}",
            HttpClient::buildBody([
                "name" => $name,
                "purpose" => $purpose,
                "plan_price_ids" => $planPriceIds,
                "phases" => $phases,
                "metadata" => $metadata,
                "starts_at" => $startsAt,
                "ends_at" => $endsAt,
                "active" => $active,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid Offer response payload");
        }

        return Offer::fromArray($response->data);
    }

    /**
     * Soft-delete an offer. Existing applications and their accepted terms remain available for billing and audit.
     * @return DeletedOffer
     */
    public function delete(
        string $id,
    ): DeletedOffer {
        $response = $this->http->delete(
            "/offers/{$id}",
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid DeletedOffer response payload");
        }

        return DeletedOffer::fromArray($response->data);
    }

    /**
     * List the organization's canonical introductory and promotional offers.
     * @return OffersListResult
     */
    public function list(
        ?string $cursor = null,
        ?int $limit = null,
        ?string $planPriceId = null,
        ?string $purpose = null,
        ?bool $active = null,
    ): OffersListResult {
        $response = $this->http->get(
            "/offers",
            HttpClient::buildBody([
                "cursor" => $cursor,
                "limit" => $limit,
                "plan_price_id" => $planPriceId,
                "purpose" => $purpose,
                "active" => $active,
            ]),
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid OffersListResult response payload");
        }

        return OffersListResult::fromArray($response->data);
    }

    /**
     * Create a canonical offer scoped to one or more plan prices. Currency-specific phases require an explicit USD value and never fall back across currencies.
     * @param string[] $planPriceIds
     * @param CreateOfferParamsPhasesItem[] $phases
     * @param array<string, mixed>|null $metadata
     * @return Offer
     */
    public function create(
        string $name,
        string $purpose,
        array $planPriceIds,
        array $phases,
        ?array $metadata = null,
        ?string $startsAt = null,
        ?string $endsAt = null,
        ?bool $active = null,
        ?string $idempotencyKey = null,
    ): Offer {
        $response = $this->http->post(
            "/offers",
            HttpClient::buildBody([
                "name" => $name,
                "purpose" => $purpose,
                "plan_price_ids" => $planPriceIds,
                "phases" => $phases,
                "metadata" => $metadata,
                "starts_at" => $startsAt,
                "ends_at" => $endsAt,
                "active" => $active,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid Offer response payload");
        }

        return Offer::fromArray($response->data);
    }
}
