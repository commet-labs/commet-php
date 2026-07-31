<?php

declare(strict_types=1);

namespace Commet\Models;

class CreateOfferParamsPhasesItemVariant3 extends CreateOfferParamsPhasesItem
{
    public function __construct(
        public readonly string $type,
        /** @var CreateOfferParamsPhasesItemVariant3AmountsItem[] */
        public readonly array $amounts,
        public readonly ?int $durationCycles = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            type: $data["type"],
            amounts: array_map(fn(array $item) => CreateOfferParamsPhasesItemVariant3AmountsItem::fromArray($item), $data["amounts"]),
            durationCycles: $data["duration_cycles"] ?? null,
        );
    }
}
