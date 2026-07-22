<?php

declare(strict_types=1);

namespace Commet\Resources;

use Commet\ApiResponse;
use Commet\HttpClient;
use Commet\Models\ClaimLink;

class ProvisioningResource
{
    public function __construct(
        private readonly HttpClient $http,
    ) {}

    /**
     * Issue a fresh claim link for an organization that was provisioned headlessly and has not been claimed yet. Any previously issued link stops working.
     * @return ApiResponse<ClaimLink>
     */
    public function createClaimLink(
        ?string $idempotencyKey = null,
    ): ApiResponse {
        $response = $this->http->post(
            "/claim-link",
            idempotencyKey: $idempotencyKey,
        );

        if ($response->success && is_array($response->data)) {
            return new ApiResponse(
                success: true,
                data: ClaimLink::fromArray($response->data),
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }
}
