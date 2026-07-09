<?php

declare(strict_types=1);

namespace Commet\Webhooks;

use Commet\Enums\PaymentProvider;

/** Fired once, when the subscription's first charge succeeds and it becomes active — this is where you grant access. Never re-fired on renewals; use payment.received for per-charge notifications. */
final class SubscriptionActivatedData
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
        public readonly ?PaymentProvider $provider,
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
            provider: isset($data["provider"]) ? PaymentProvider::fromArray($data["provider"]) : null,
        );
    }
}
