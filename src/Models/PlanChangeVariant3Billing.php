<?php

declare(strict_types=1);

namespace Commet\Models;

class PlanChangeVariant3Billing
{
    public function __construct(
        public readonly int $credit,
        public readonly int $creditsApplied,
        public readonly int $charge,
        public readonly int $taxAmount,
        public readonly int $netAmount,
        public readonly int $totalCharged,
        public readonly int $remainingCreditBalance,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            credit: $data["credit"],
            creditsApplied: $data["credits_applied"],
            charge: $data["charge"],
            taxAmount: $data["tax_amount"],
            netAmount: $data["net_amount"],
            totalCharged: $data["total_charged"],
            remainingCreditBalance: $data["remaining_credit_balance"],
        );
    }
}
