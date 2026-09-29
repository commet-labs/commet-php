<?php

declare(strict_types=1);

namespace Commet\Models;

class SeatBalanceCollection implements \JsonSerializable
{
    public function __construct(
        /** @var array<string, SeatBalanceCollectionBalancesValue> */
        public readonly array $balances,
        public readonly string $object,
        public readonly bool $livemode,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["balances"] = $this->balances;
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
            balances: array_map(fn(array $item) => SeatBalanceCollectionBalancesValue::fromArray($item), $data["balances"]),
            object: $data["object"],
            livemode: $data["livemode"],
        );
    }
}
