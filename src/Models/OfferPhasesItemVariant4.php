<?php

declare(strict_types=1);

namespace Commet\Models;

class OfferPhasesItemVariant4 extends OfferPhasesItem
{
    public function __construct(
        public readonly string $type,
        public readonly int $durationCycles,
        /** @var OfferPhasesItemVariant4PricesItem[] */
        public readonly array $prices,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            type: $data["type"],
            durationCycles: $data["duration_cycles"],
            prices: array_map(fn(array $item) => OfferPhasesItemVariant4PricesItem::fromArray($item), $data["prices"]),
        );
    }
}
