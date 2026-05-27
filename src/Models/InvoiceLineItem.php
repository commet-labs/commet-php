<?php

declare(strict_types=1);

namespace Commet\Models;

class InvoiceLineItem
{
    public function __construct(
        public readonly string $lineType,
        public readonly int $quantity,
        public readonly int $unitAmount,
        public readonly int $amount,
        public readonly ?string $featureName = null,
        public readonly ?string $description = null,
        public readonly ?int $includedAmount = null,
        public readonly ?int $usedAmount = null,
        public readonly ?int $overageAmount = null,
        public readonly ?string $discountType = null,
        public readonly ?int $discountValue = null,
        public readonly ?string $discountName = null,
        public readonly ?string $chargeType = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            lineType: $data['line_type'],
            quantity: $data['quantity'],
            unitAmount: $data['unit_amount'],
            amount: $data['amount'],
            featureName: $data['feature_name'] ?? null,
            description: $data['description'] ?? null,
            includedAmount: $data['included_amount'] ?? null,
            usedAmount: $data['used_amount'] ?? null,
            overageAmount: $data['overage_amount'] ?? null,
            discountType: $data['discount_type'] ?? null,
            discountValue: $data['discount_value'] ?? null,
            discountName: $data['discount_name'] ?? null,
            chargeType: $data['charge_type'] ?? null,
        );
    }
}
