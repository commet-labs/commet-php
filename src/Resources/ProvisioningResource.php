<?php

declare(strict_types=1);

namespace Commet\Resources;

use Commet\HttpClient;
use Commet\Models\ClaimLink;

class ProvisioningResource
{
    public function __construct(
        private readonly HttpClient $http,
    ) {}

    /**
     * Issue a fresh claim link for an organization that was provisioned headlessly and has not been claimed yet. Any previously issued link stops working.
     * @return ClaimLink
     */
    public function createClaimLink(
        ?string $idempotencyKey = null,
    ): ClaimLink {
        $response = $this->http->post(
            "/claim-link",
            idempotencyKey: $idempotencyKey,
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid ClaimLink response payload");
        }

        return ClaimLink::fromArray($response->data);
    }
}
