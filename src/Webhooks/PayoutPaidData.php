<?php

declare(strict_types=1);

namespace Commet\Webhooks;

use Commet\Models\WebhookBankRef;

/** Fired when the bank settlement of a payout completes — the moment the money actually reaches your bank account, confirmed by the payment provider. Fires exactly once per payout. */
final class PayoutPaidData
{
    public function __construct(
        public readonly string $payoutId,
        public readonly float $amount,
        public readonly float $fee,
        public readonly float $netAmount,
        public readonly string $currency,
        public readonly string $status,
        public readonly ?WebhookBankRef $destinationBank,
        public readonly ?string $paidAt,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            payoutId: $data["payoutId"],
            amount: $data["amount"],
            fee: $data["fee"],
            netAmount: $data["netAmount"],
            currency: $data["currency"],
            status: $data["status"],
            destinationBank: isset($data["destinationBank"]) ? WebhookBankRef::fromArray($data["destinationBank"]) : null,
            paidAt: $data["paidAt"] ?? null,
        );
    }
}
