<?php

declare(strict_types=1);

namespace Commet\Exceptions;

class ApiException extends CommetException
{
    public function __construct(
        string $message,
        int $statusCode,
        ?string $code = null,
        mixed $details = null,
        ?string $type = null,
        ?string $param = null,
        ?string $docUrl = null,
        ?\Throwable $previous = null,
    ) {
        parent::__construct($message, $code, $statusCode, $details, $type, $param, $docUrl, $previous);
    }
}
