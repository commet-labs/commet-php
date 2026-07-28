<?php

declare(strict_types=1);

namespace Commet\Resources;

use Commet\HttpClient;
use Commet\Models\PortalAccess;

class PortalResource
{
    public function __construct(
        private readonly HttpClient $http,
    ) {}

    /**
     * Generate a customer portal URL. Exactly one identifier (email or customerId) is required.
     * @return PortalAccess
     */
    public function getUrl(
        ?string $email = null,
        ?string $returnUrl = null,
        ?string $customerId = null,
        ?string $idempotencyKey = null,
    ): PortalAccess {
        $response = $this->http->post(
            "/portal/sessions",
            HttpClient::buildBody([
                "email" => $email,
                "return_url" => $returnUrl,
                "customer_id" => $customerId,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if (!is_array($response->data)) {
            throw new \UnexpectedValueException("Invalid PortalAccess response payload");
        }

        return PortalAccess::fromArray($response->data);
    }
}
