<?php

declare(strict_types=1);

namespace Commet\Exceptions;

class CommetException extends \RuntimeException
{
    public readonly ?string $errorCode;
    public readonly ?int $statusCode;
    public readonly mixed $details;

    public function __construct(
        string $message,
        ?string $code = null,
        ?int $statusCode = null,
        mixed $details = null,
        ?\Throwable $previous = null,
    ) {
        parent::__construct($message, 0, $previous);
        $this->errorCode = $code;
        $this->statusCode = $statusCode;
        $this->details = $details;
    }
}
