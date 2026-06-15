<?php

declare(strict_types=1);

namespace Commet\Webhooks;

/** Fired when a recurring charge fails. This event is for recurring charge failures only — card declines during initial checkout do not trigger this event. */
final class PaymentFailedData
{
    public function __construct(
        public readonly ?string $invoiceId,
        public readonly ?string $invoiceNumber,
        public readonly string $customerId,
        public readonly ?string $subscriptionId,
        public readonly ?string $failureCode,
        public readonly ?string $failureMessage,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            invoiceId: $data["invoiceId"] ?? null,
            invoiceNumber: $data["invoiceNumber"] ?? null,
            customerId: $data["customerId"],
            subscriptionId: $data["subscriptionId"] ?? null,
            failureCode: $data["failureCode"] ?? null,
            failureMessage: $data["failureMessage"] ?? null,
        );
    }
}
