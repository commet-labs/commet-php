<?php

declare(strict_types=1);

namespace Commet\Models;

class TransactionListItemPaymentContextRecoveryVariant1 extends TransactionListItemPaymentContextRecovery implements \JsonSerializable
{
    public function __construct(
        public readonly string $type,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["type"] = $this->type;
        return (object) $values;
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            type: $data["type"],
        );
    }
}
