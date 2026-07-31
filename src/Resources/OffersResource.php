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
     * Retrieve reusable offer terms by public ID.
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
     * Replace reusable offer terms. Existing applications keep their immutable accepted terms.
     * @param UpdateOfferParamsPhasesItem[] $phases
     * @param array<string, mixed>|null $metadata
     * @return Offer
     */
    public function update(
        string $id,
        string $name,
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
     * Soft-delete an Offer. Existing applications and their accepted terms remain available for billing and audit.
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
     * List reusable offer terms. Offers are independent from plans, prices, eligibility, and distribution channels.
     * @return OffersListResult
     */
    public function list(
        ?string $cursor = null,
        ?int $limit = null,
        ?bool $active = null,
    ): OffersListResult {
        $response = $this->http->get(
            "/offers",
            HttpClient::buildBody([
                "cursor" => $cursor,
                "limit" => $limit,
                "active" => $active,
            ]),
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid OffersListResult response payload");
        }

        return OffersListResult::fromArray($response->data);
    }

    /**
     * Create reusable offer terms without assigning a plan, price, eligibility rule, or distribution channel.
     * @param CreateOfferParamsPhasesItem[] $phases
     * @param array<string, mixed>|null $metadata
     * @return Offer
     */
    public function create(
        string $name,
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
