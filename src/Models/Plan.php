<?php

declare(strict_types=1);

namespace Commet\Models;

use Commet\Enums\BillingInterval;
use Commet\Enums\ConsumptionModel;
use Commet\Enums\DiscountType;
use Commet\Enums\FeatureType;

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
        public readonly string $object,
        public readonly bool $livemode,
        public readonly ?string $description = null,
        public readonly ?ConsumptionModel $consumptionModel = null,
        public readonly ?bool $blockOnExhaustion = null,
        public readonly ?string $planGroupId = null,
        /** @var array<string, mixed>|null */
        public readonly ?array $metadata = null,
        /** @var list<array<string, mixed>>|null */
        public readonly ?array $features = null,
        /** @var list<array<string, mixed>>|null */
        public readonly ?array $prices = null,
        /** @var list<array<string, mixed>>|null */
        public readonly ?array $exchangeRates = null,
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
            object: $data["object"],
            livemode: $data["livemode"],
            description: $data["description"] ?? null,
            consumptionModel: isset($data["consumption_model"]) ? ConsumptionModel::from($data["consumption_model"]) : null,
            blockOnExhaustion: $data["block_on_exhaustion"] ?? null,
            planGroupId: $data["plan_group_id"] ?? null,
            metadata: $data["metadata"] ?? null,
            features: $data["features"] ?? null,
            prices: $data["prices"] ?? null,
            exchangeRates: $data["exchange_rates"] ?? null,
        );
    }
}
