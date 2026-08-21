<?php

declare(strict_types=1);

namespace Commet\Exceptions;

class CommetException extends \RuntimeException implements \JsonSerializable
{
    public readonly ?string $errorCode;
    public readonly ?int $statusCode;
    public readonly mixed $details;
    public readonly ?string $type;
    public readonly ?string $param;
    public readonly ?string $docUrl;
    public readonly ?string $requestId;

    public function __construct(
        string $message,
        ?string $code = null,
        ?int $statusCode = null,
        mixed $details = null,
        ?string $type = null,
        ?string $param = null,
        ?string $docUrl = null,
        ?\Throwable $previous = null,
        ?string $requestId = null,
    ) {
        parent::__construct($message, 0, $previous);
        $this->errorCode = $code;
        $this->statusCode = $statusCode;
        $this->details = $details;
        $this->type = $type;
        $this->param = $param;
        $this->docUrl = $docUrl;
        $this->requestId = $requestId;
    }

    /** @return array<string, mixed> */
    public function jsonSerialize(): array
    {
        return [
            'message' => $this->getMessage(),
            'type' => $this->type,
            'code' => $this->errorCode,
            'statusCode' => $this->statusCode,
            'param' => $this->param,
            'details' => $this->details,
            'requestId' => $this->requestId,
            'docUrl' => $this->docUrl,
        ];
    }
}
