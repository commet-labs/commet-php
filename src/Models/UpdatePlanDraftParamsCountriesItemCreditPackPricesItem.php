<?php

declare(strict_types=1);

namespace Commet\Models;

abstract class UpdatePlanDraftParamsCountriesItemCreditPackPricesItem
{
    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return UpdatePlanDraftParamsCountriesItemCreditPackPricesItemVariant1::fromArray($data);
    }
}
