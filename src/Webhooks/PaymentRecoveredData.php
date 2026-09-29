<?php

declare(strict_types=1);

namespace Commet\Webhooks;

use Commet\Enums\PaymentMethod;
use Commet\Enums\SubPaymentMethod;

/** Fired when an outstanding invoice that previously failed is successfully paid — automatically on retry or by the customer through the portal. The subscription returns to active at the same time; use this event to close the dunning flow you opened on payment.failed. */
final class PaymentRecoveredData
{
    public function __construct(
        public readonly string $invoiceId,
        public readonly string $invoiceNumber,
        public readonly float $invoiceTotal,
        public readonly string $customerId,
        public readonly ?string $subscriptionId,
        public readonly ?string $provider,
        public readonly ?PaymentMethod $paymentMethod,
        public readonly ?SubPaymentMethod $subPaymentMethod,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            invoiceId: $data["invoiceId"],
            invoiceNumber: $data["invoiceNumber"],
            invoiceTotal: $data["invoiceTotal"],
            customerId: $data["customerId"],
            subscriptionId: $data["subscriptionId"] ?? null,
            provider: $data["provider"] ?? null,
            paymentMethod: isset($data["paymentMethod"]) ? PaymentMethod::from($data["paymentMethod"]) : null,
            subPaymentMethod: isset($data["subPaymentMethod"]) ? SubPaymentMethod::from($data["subPaymentMethod"]) : null,
        );
    }
}
