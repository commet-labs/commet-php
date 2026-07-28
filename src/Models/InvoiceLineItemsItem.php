<?php

declare(strict_types=1);

namespace Commet\Models;

class InvoiceLineItemsItem
{
    public function __construct(
        public readonly string $lineType,
        public readonly string $description,
        public readonly int $quantity,
        public readonly int $unitAmount,
        public readonly int $amount,
        public readonly string $chargeType,
        public readonly ?string $featureName = null,
        public readonly ?int $includedAmount = null,
        public readonly ?int $usedAmount = null,
        public readonly ?int $overageAmount = null,
        public readonly ?string $discountType = null,
        public readonly ?int $discountValue = null,
        public readonly ?string $discountName = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            lineType: $data["line_type"],
            description: $data["description"],
            quantity: $data["quantity"],
            unitAmount: $data["unit_amount"],
            amount: $data["amount"],
            chargeType: $data["charge_type"],
            featureName: $data["feature_name"] ?? null,
            includedAmount: $data["included_amount"] ?? null,
            usedAmount: $data["used_amount"] ?? null,
            overageAmount: $data["overage_amount"] ?? null,
            discountType: $data["discount_type"] ?? null,
            discountValue: $data["discount_value"] ?? null,
            discountName: $data["discount_name"] ?? null,
        );
    }
}
