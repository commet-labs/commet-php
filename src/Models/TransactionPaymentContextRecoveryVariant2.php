<?php

declare(strict_types=1);

namespace Commet\Models;

class TransactionPaymentContextRecoveryVariant2 extends TransactionPaymentContextRecovery implements \JsonSerializable
{
    public function __construct(
        public readonly string $type,
        public readonly int $attempt,
        public readonly int $maxAttempts,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["type"] = $this->type;
        $values["attempt"] = $this->attempt;
        $values["maxAttempts"] = $this->maxAttempts;
        return (object) $values;
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            type: $data["type"],
            attempt: $data["attempt"],
            maxAttempts: $data["max_attempts"],
        );
    }
}
