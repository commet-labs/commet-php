<?php

declare(strict_types=1);

namespace Commet\Models;

abstract class UpdatePlanDraftParamsCountriesItemAddonPricesItem
{
    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return UpdatePlanDraftParamsCountriesItemAddonPricesItemVariant1::fromArray($data);
    }
}
