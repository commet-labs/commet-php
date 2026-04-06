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

    public function get(string $code, string $externalId): ApiResponse
    {
        return $this->http->get("/features/{$code}", ['external_id' => $externalId]);
    }

    public function check(string $code, string $externalId): ApiResponse
    {
        $result = $this->http->get("/features/{$code}", ['external_id' => $externalId]);

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

    public function canUse(string $code, string $externalId): ApiResponse
    {
        return $this->http->get(
            "/features/{$code}",
            ['external_id' => $externalId, 'action' => 'canUse'],
        );
    }

    public function list(string $externalId): ApiResponse
    {
        return $this->http->get('/features', ['external_id' => $externalId]);
    }
}
