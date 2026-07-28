<?php

declare(strict_types=1);

namespace Commet\Models;

class UpdateOfferParamsPhasesItemVariant3 extends UpdateOfferParamsPhasesItem
{
    public function __construct(
        public readonly string $type,
        public readonly int $durationCycles,
        /** @var UpdateOfferParamsPhasesItemVariant3AmountsItem[] */
        public readonly array $amounts,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            type: $data["type"],
            durationCycles: $data["duration_cycles"],
            amounts: array_map(fn(array $item) => UpdateOfferParamsPhasesItemVariant3AmountsItem::fromArray($item), $data["amounts"]),
        );
    }
}
