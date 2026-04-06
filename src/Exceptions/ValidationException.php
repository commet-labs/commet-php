<?php

declare(strict_types=1);

namespace Commet\Exceptions;

class ValidationException extends CommetException
{
    /**
     * @param array<string, list<string>> $validationErrors
     */
    public function __construct(
        string $message,
        public readonly array $validationErrors = [],
    ) {
        parent::__construct($message);
    }
}
