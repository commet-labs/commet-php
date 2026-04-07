<?php

declare(strict_types=1);

namespace Commet\Resources;

use Commet\ApiResponse;
use Commet\HttpClient;

class PortalResource
{
    public function __construct(
        private readonly HttpClient $http,
    ) {}

    public function getUrl(
        ?string $customerId = null,
        ?string $email = null,
        ?string $idempotencyKey = null,
    ): ApiResponse {
        return $this->http->post(
            '/portal/request-access',
            HttpClient::buildBody([
                'customer_id' => $customerId,
                'email' => $email,
            ]),
            idempotencyKey: $idempotencyKey,
        );
    }
}
