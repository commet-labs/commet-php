<?php

declare(strict_types=1);

namespace Commet\Models;

class PlanFeaturesItemRegionalPricesItem implements \JsonSerializable
{
    public function __construct(
        public readonly string $currency,
        public readonly bool $autoSynced,
        public readonly ?int $overageUnitPrice = null,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["currency"] = $this->currency;
        $values["overageUnitPrice"] = $this->overageUnitPrice;
        $values["autoSynced"] = $this->autoSynced;
        return (object) $values;
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            currency: $data["currency"],
            autoSynced: $data["auto_synced"],
            overageUnitPrice: $data["overage_unit_price"] ?? null,
        );
    }
}
