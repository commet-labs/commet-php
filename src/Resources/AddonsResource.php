<?php

declare(strict_types=1);

namespace Commet\Resources;

use Commet\ApiResponse;
use Commet\HttpClient;

class AddonsResource
{
    public function __construct(
        private readonly HttpClient $http,
    ) {}

    /**
     * @return ApiResponse<array<int, array<string, mixed>>>
     */
    public function getActive(string $customerId): ApiResponse
    {
        return $this->http->get('/addons/active', ['customer_id' => $customerId]);
    }
}
