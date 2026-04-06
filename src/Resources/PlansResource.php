<?php

declare(strict_types=1);

namespace Commet\Resources;

use Commet\ApiResponse;
use Commet\HttpClient;

class PlansResource
{
    public function __construct(
        private readonly HttpClient $http,
    ) {}

    public function list(
        ?bool $includePrivate = null,
        ?int $limit = null,
        ?string $cursor = null,
    ): ApiResponse {
        return $this->http->get(
            '/plans',
            HttpClient::buildBody([
                'include_private' => $includePrivate,
                'limit' => $limit,
                'cursor' => $cursor,
            ]),
        );
    }

    public function get(string $planCode): ApiResponse
    {
        return $this->http->get("/plans/{$planCode}");
    }
}
