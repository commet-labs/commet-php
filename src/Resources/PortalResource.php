<?php

declare(strict_types=1);

namespace Commet\Resources;

use Commet\ApiResponse;
use Commet\HttpClient;
use Commet\Models\PortalAccess;

class PortalResource
{
    public function __construct(
        private readonly HttpClient $http,
    ) {}

    /**
     * Generate a customer portal URL. Exactly one identifier (email or customerId) is required.
     * @return ApiResponse<PortalAccess>
     */
    public function getUrl(
        ?string $email = null,
        ?string $customerId = null,
        ?string $returnUrl = null,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        $response = $this->http->post(
            "/portal/request-access",
            HttpClient::buildBody([
                "email" => $email,
                "customer_id" => $customerId,
                "return_url" => $returnUrl,
            ]),
            idempotencyKey: $idempotencyKey,
        );

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: PortalAccess::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }
}
