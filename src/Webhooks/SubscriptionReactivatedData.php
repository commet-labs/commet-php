<?php

declare(strict_types=1);

namespace Commet\Webhooks;

use Commet\Enums\PaymentProvider;

/** Fired when a canceled subscription is reactivated and its reactivation charge succeeds. The subscription returns to active with a fresh invoice and a billing period anchored to the reactivation date. Distinct from subscription.activated (first activation) and payment.recovered (past_due recovery, which keeps the original anchor). */
final class SubscriptionReactivatedData
{
    public function __construct(
        public readonly string $subscriptionId,
        public readonly string $customerId,
        public readonly string $status,
        public readonly string $currentPeriodStart,
        public readonly string $currentPeriodEnd,
        public readonly ?string $name,
        public readonly string $invoiceId,
        public readonly string $invoiceNumber,
        public readonly float $invoiceTotal,
        public readonly string $invoiceCurrency,
        public readonly PaymentProvider $provider,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            subscriptionId: $data["subscriptionId"],
            customerId: $data["customerId"],
            status: $data["status"],
            currentPeriodStart: $data["currentPeriodStart"],
            currentPeriodEnd: $data["currentPeriodEnd"],
            name: $data["name"] ?? null,
            invoiceId: $data["invoiceId"],
            invoiceNumber: $data["invoiceNumber"],
            invoiceTotal: $data["invoiceTotal"],
            invoiceCurrency: $data["invoiceCurrency"],
            provider: PaymentProvider::fromArray($data["provider"]),
        );
    }
}
