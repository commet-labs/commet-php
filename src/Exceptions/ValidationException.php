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
        int $statusCode,
        public readonly array $validationErrors = [],
        mixed $details = null,
        ?string $type = null,
        ?string $param = null,
        ?string $docUrl = null,
        ?string $requestId = null,
    ) {
        parent::__construct(
            $message,
            'validation_error',
            $statusCode,
            $details,
            $type,
            $param,
            $docUrl,
            requestId: $requestId,
        );
    }

    /** @return array<string, mixed> */
    public function jsonSerialize(): array
    {
        return [...parent::jsonSerialize(), 'validationErrors' => $this->validationErrors];
    }
}
