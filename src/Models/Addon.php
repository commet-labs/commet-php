<?php

declare(strict_types=1);

namespace Commet\Models;

class Addon
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly string $slug,
        public readonly int $basePrice,
        public readonly string $consumptionModel,
        public readonly string $featureCode,
        public readonly string $featureName,
        public readonly string $createdAt,
        public readonly string $updatedAt,
        public readonly string $object,
        public readonly bool $livemode,
        public readonly ?string $description = null,
        public readonly ?int $includedUnits = null,
        public readonly ?int $overageRate = null,
        public readonly ?int $creditCost = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data["id"],
            name: $data["name"],
            slug: $data["slug"],
            basePrice: $data["base_price"],
            consumptionModel: $data["consumption_model"],
            featureCode: $data["feature_code"],
            featureName: $data["feature_name"],
            createdAt: $data["created_at"],
            updatedAt: $data["updated_at"],
            object: $data["object"],
            livemode: $data["livemode"],
            description: $data["description"] ?? null,
            includedUnits: $data["included_units"] ?? null,
            overageRate: $data["overage_rate"] ?? null,
            creditCost: $data["credit_cost"] ?? null,
        );
    }
}
