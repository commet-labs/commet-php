<?php

declare(strict_types=1);

namespace Commet\Models;

class SentInvoice implements \JsonSerializable
{
    public function __construct(
        public readonly bool $sent,
        public readonly string $sentAt,
        public readonly string $object,
        public readonly bool $livemode,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["sent"] = $this->sent;
        $values["sentAt"] = $this->sentAt;
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
            sent: $data["sent"],
            sentAt: $data["sent_at"],
            object: $data["object"],
            livemode: $data["livemode"],
        );
    }
}
