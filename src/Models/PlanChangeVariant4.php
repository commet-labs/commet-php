<?php

declare(strict_types=1);

namespace Commet\Models;

class PlanChangeVariant4 extends PlanChange implements \JsonSerializable
{
    public function __construct(
        public readonly string $outcome,
        public readonly string $invoiceId,
        public readonly string $object,
        public readonly bool $livemode,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["outcome"] = $this->outcome;
        $values["invoiceId"] = $this->invoiceId;
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
            outcome: $data["outcome"],
            invoiceId: $data["invoice_id"],
            object: $data["object"],
            livemode: $data["livemode"],
        );
    }
}
