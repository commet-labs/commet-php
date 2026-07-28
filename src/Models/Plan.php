<?php

declare(strict_types=1);

namespace Commet\Models;

use Commet\Enums\ConsumptionModel;

class Plan
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly string $code,
        public readonly bool $isPublic,
        public readonly bool $isDefault,
        public readonly bool $isFree,
        public readonly int $sortOrder,
        public readonly string $createdAt,
        public readonly string $updatedAt,
        /** @var PlanFeaturesItem[] */
        public readonly array $features,
        /** @var PlanPricesItem[] */
        public readonly array $prices,
        /** @var PlanExchangeRatesItem[] */
        public readonly array $exchangeRates,
        public readonly string $object,
        public readonly bool $livemode,
        public readonly ?string $description = null,
        public readonly ?ConsumptionModel $consumptionModel = null,
        public readonly ?bool $blockOnExhaustion = null,
        public readonly ?string $planGroupId = null,
        /** @var array<string, mixed>|null */
        public readonly ?array $metadata = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data["id"],
            name: $data["name"],
            code: $data["code"],
            isPublic: $data["is_public"],
            isDefault: $data["is_default"],
            isFree: $data["is_free"],
            sortOrder: $data["sort_order"],
            createdAt: $data["created_at"],
            updatedAt: $data["updated_at"],
            features: array_map(fn(array $item) => PlanFeaturesItem::fromArray($item), $data["features"]),
            prices: array_map(fn(array $item) => PlanPricesItem::fromArray($item), $data["prices"]),
            exchangeRates: array_map(fn(array $item) => PlanExchangeRatesItem::fromArray($item), $data["exchange_rates"]),
            object: $data["object"],
            livemode: $data["livemode"],
            description: $data["description"] ?? null,
            consumptionModel: isset($data["consumption_model"]) ? ConsumptionModel::from($data["consumption_model"]) : null,
            blockOnExhaustion: $data["block_on_exhaustion"] ?? null,
            planGroupId: $data["plan_group_id"] ?? null,
            metadata: $data["metadata"] ?? null,
        );
    }
}
