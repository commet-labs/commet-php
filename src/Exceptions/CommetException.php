<?php

declare(strict_types=1);

namespace Commet\Exceptions;

class CommetException extends \RuntimeException
{
    public function __construct(
        string $message,
        public readonly ?string $code = null,
        public readonly ?int $statusCode = null,
        public readonly mixed $details = null,
        ?\Throwable $previous = null,
    ) {
        parent::__construct($message, 0, $previous);
    }
}
