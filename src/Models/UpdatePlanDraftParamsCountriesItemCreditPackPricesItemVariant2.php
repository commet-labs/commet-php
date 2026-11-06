<?php

declare(strict_types=1);

namespace Commet\Models;

class UpdatePlanDraftParamsCountriesItemCreditPackPricesItemVariant2 extends UpdatePlanDraftParamsCountriesItemCreditPackPricesItem implements \JsonSerializable
{
    public function __construct(
        public readonly string $creditPackId,
        public readonly mixed $followBase,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["creditPackId"] = $this->creditPackId;
        $values["followBase"] = $this->followBase;
        return (object) $values;
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            creditPackId: $data["credit_pack_id"],
            followBase: $data["follow_base"],
        );
    }
}
