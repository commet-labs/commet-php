<?php

declare(strict_types=1);

namespace Commet\Webhooks;

use Commet\Enums\PaymentMethod;
use Commet\Enums\SubPaymentMethod;

/** Fired when an invoice-linked subscription charge fails. */
final class PaymentFailedData
{
    public function __construct(
        /** @var array<string, mixed> */
        public readonly ?array $paymentContext,
        public readonly string $invoiceId,
        public readonly string $invoiceNumber,
        public readonly string $customerId,
        public readonly ?string $subscriptionId,
        public readonly string $provider,
        public readonly PaymentMethod|string|null $paymentMethod,
        public readonly SubPaymentMethod|string|null $subPaymentMethod,
        public readonly string $failureCode,
        public readonly string $failureMessage,
        public readonly ?string $recoveryUrl,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            paymentContext: $data["paymentContext"] ?? null,
            invoiceId: $data["invoiceId"],
            invoiceNumber: $data["invoiceNumber"],
            customerId: $data["customerId"],
            subscriptionId: $data["subscriptionId"] ?? null,
            provider: $data["provider"],
            paymentMethod: isset($data["paymentMethod"]) ? PaymentMethod::tryFrom($data["paymentMethod"]) ?? $data["paymentMethod"] : null,
            subPaymentMethod: isset($data["subPaymentMethod"]) ? SubPaymentMethod::tryFrom($data["subPaymentMethod"]) ?? $data["subPaymentMethod"] : null,
            failureCode: $data["failureCode"],
            failureMessage: $data["failureMessage"],
            recoveryUrl: $data["recoveryUrl"] ?? null,
        );
    }
}
