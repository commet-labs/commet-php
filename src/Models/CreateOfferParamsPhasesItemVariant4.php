<?php

declare(strict_types=1);

namespace Commet\Models;

class CreateOfferParamsPhasesItemVariant4 extends CreateOfferParamsPhasesItem implements \JsonSerializable
{
    public function __construct(
        public readonly string $type,
        /** @var CreateOfferParamsPhasesItemVariant4PricesItem[] */
        public readonly array $prices,
        public readonly ?int $durationCycles = null,
        public readonly ?string $durationInterval = null,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["type"] = $this->type;
        $values["durationCycles"] = $this->durationCycles;
        if ($this->durationInterval !== null) {
            $values["durationInterval"] = $this->durationInterval;
        }
        $values["prices"] = $this->prices;
        return (object) $values;
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            type: $data["type"],
            prices: array_map(fn(array $item) => CreateOfferParamsPhasesItemVariant4PricesItem::fromArray($item), $data["prices"]),
            durationCycles: $data["duration_cycles"] ?? null,
            durationInterval: $data["duration_interval"] ?? null,
        );
    }
}
