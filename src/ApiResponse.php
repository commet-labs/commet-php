<?php

declare(strict_types=1);

namespace Commet;

class ApiResponse
{
    public function __construct(
        public readonly bool $success,
        public readonly mixed $data = null,
        public readonly ?string $code = null,
        public readonly ?string $message = null,
        public readonly ?bool $hasMore = null,
        public readonly ?string $nextCursor = null,
    ) {}
}
