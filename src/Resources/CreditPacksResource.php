<?php

declare(strict_types=1);

namespace Commet\Resources;

use Commet\ApiResponse;
use Commet\HttpClient;
use Commet\Models\CreditPack;

class CreditPacksResource
{
    public function __construct(
        private readonly HttpClient $http,
    ) {}

    /**
     * @return ApiResponse<CreditPack[]>
     */
    public function list(): ApiResponse
    {
        $response = $this->http->get('/credit-packs');

        if ($response->success && is_array($response->data)) {
            $packs = array_map(
                fn(array $item) => CreditPack::fromArray($item),
                $response->data,
            );

            return new ApiResponse(
                success: true,
                data: $packs,
                code: $response->code,
                message: $response->message,
            );
        }

        return $response;
    }
}
