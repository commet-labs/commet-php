<?php

declare(strict_types=1);

namespace Commet\Models;

abstract class UpdatePlanDraftParamsCountriesItemPricesItem
{
    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return UpdatePlanDraftParamsCountriesItemPricesItemVariant1::fromArray($data);
    }
}
