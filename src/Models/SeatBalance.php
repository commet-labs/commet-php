<?php

declare(strict_types=1);

namespace Commet\Models;

class SeatBalance implements \JsonSerializable
{
    public function __construct(
        public readonly int $current,
        public readonly string $asOf,
        public readonly string $object,
        public readonly bool $livemode,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["current"] = $this->current;
        $values["asOf"] = $this->asOf;
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
            current: $data["current"],
            asOf: $data["as_of"],
            object: $data["object"],
            livemode: $data["livemode"],
        );
    }
}
