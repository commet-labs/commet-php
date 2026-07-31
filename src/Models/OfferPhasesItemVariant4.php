<?php

declare(strict_types=1);

namespace Commet\Models;

class OfferPhasesItemVariant4 extends OfferPhasesItem
{
    public function __construct(
        public readonly string $type,
        /** @var OfferPhasesItemVariant4PricesItem[] */
        public readonly array $prices,
        public readonly ?int $durationCycles = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            type: $data["type"],
            prices: array_map(fn(array $item) => OfferPhasesItemVariant4PricesItem::fromArray($item), $data["prices"]),
            durationCycles: $data["duration_cycles"] ?? null,
        );
    }
}
