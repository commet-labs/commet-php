<?php

declare(strict_types=1);

namespace Commet\Models;

class CreditGrant implements \JsonSerializable
{
    public function __construct(
        public readonly int $credits,
        public readonly string $object,
        public readonly bool $livemode,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["credits"] = $this->credits;
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
            credits: $data["credits"],
            object: $data["object"],
            livemode: $data["livemode"],
        );
    }
}
