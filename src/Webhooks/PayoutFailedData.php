<?php

declare(strict_types=1);

namespace Commet\Webhooks;

/** Fired when the provider reports a payout could not be completed — most commonly a bank rejection (closed account, invalid details). The funds return to your available balance. */
final class PayoutFailedData
{
    public function __construct(
        public readonly string $payoutId,
        public readonly float $amount,
        public readonly float $fee,
        public readonly float $netAmount,
        public readonly string $currency,
        public readonly string $status,
        public readonly ?WebhookBankRef $destinationBank,
        public readonly ?string $failedAt,
        public readonly ?string $failureCode,
        public readonly ?string $failureMessage,
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
            failedAt: $data["failedAt"] ?? null,
            failureCode: $data["failureCode"] ?? null,
            failureMessage: $data["failureMessage"] ?? null,
        );
    }
}
