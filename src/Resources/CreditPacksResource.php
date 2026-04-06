<?php

declare(strict_types=1);

namespace Commet\Resources;

use Commet\ApiResponse;
use Commet\HttpClient;

class CreditPacksResource
{
    public function __construct(
        private readonly HttpClient $http,
    ) {}

    public function list(): ApiResponse
    {
        return $this->http->get('/credit-packs');
    }
}
