<?php

declare(strict_types=1);

namespace Commet\Resources;

use Commet\ApiResponse;
use Commet\HttpClient;

class FeaturesResource
{
    public function __construct(
        private readonly HttpClient $http,
    ) {}

    public function get(string $code, string $customerId): ApiResponse
    {
        return $this->http->get("/features/{$code}", ['customer_id' => $customerId]);
    }

    public function check(string $code, string $customerId): ApiResponse
    {
        $result = $this->http->get("/features/{$code}", ['customer_id' => $customerId]);

        if (!$result->success || $result->data === null) {
            return new ApiResponse(
                success: false,
                data: ['allowed' => false],
                message: $result->message,
            );
        }

        return new ApiResponse(
            success: true,
            data: ['allowed' => $result->data['allowed'] ?? false],
            message: $result->message,
        );
    }

    public function canUse(string $code, string $customerId): ApiResponse
    {
        return $this->http->get(
            "/features/{$code}",
            ['customer_id' => $customerId, 'action' => 'canUse'],
        );
    }

    public function list(string $customerId): ApiResponse
    {
        return $this->http->get('/features', ['customer_id' => $customerId]);
    }
}
