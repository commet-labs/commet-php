<?php

declare(strict_types=1);

namespace Commet\Models;

class TransactionRetry implements \JsonSerializable
{
    public function __construct(
        public readonly string $originalTransactionId,
        public readonly string $invoiceId,
        public readonly string $status,
        public readonly string $object,
        public readonly bool $livemode,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["originalTransactionId"] = $this->originalTransactionId;
        $values["invoiceId"] = $this->invoiceId;
        $values["status"] = $this->status;
        $values["object"] = $this->object;
        $values["livemode"] = $this->livemode;
        return (object) $values;
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            originalTransactionId: $data["original_transaction_id"],
            invoiceId: $data["invoice_id"],
            status: $data["status"],
            object: $data["object"],
            livemode: $data["livemode"],
        );
    }
}
