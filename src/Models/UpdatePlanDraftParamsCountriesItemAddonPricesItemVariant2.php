<?php

declare(strict_types=1);

namespace Commet\Models;

class UpdatePlanDraftParamsCountriesItemAddonPricesItemVariant2 extends UpdatePlanDraftParamsCountriesItemAddonPricesItem implements \JsonSerializable
{
    public function __construct(
        public readonly string $addonId,
        public readonly mixed $followBase,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["addonId"] = $this->addonId;
        $values["followBase"] = $this->followBase;
        return (object) $values;
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            addonId: $data["addon_id"],
            followBase: $data["follow_base"],
        );
    }
}
