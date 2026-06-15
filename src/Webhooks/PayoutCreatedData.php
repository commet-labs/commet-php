<?php

declare(strict_types=1);

namespace Commet\Webhooks;

/** Fired when a payout of your available balance is requested and the transfer toward your bank is initiated. The lifecycle continues with payout.paid or payout.failed. */
final class PayoutCreatedData
{
    public function __construct(
        public readonly string $payoutId,
        public readonly float $amount,
        public readonly float $fee,
        public readonly float $netAmount,
        public readonly string $currency,
        public readonly string $status,
        public readonly ?WebhookBankRef $destinationBank,
        public readonly string $createdAt,
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
            createdAt: $data["createdAt"],
        );
    }
}
