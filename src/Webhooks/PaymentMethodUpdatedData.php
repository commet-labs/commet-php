<?php

declare(strict_types=1);

namespace Commet\Webhooks;

/** Fired when a customer replaces their default payment method through the customer portal. The new method applies to all of the customer's subscriptions. A payment method update is also a strong recovery signal for past-due subscriptions. */
final class PaymentMethodUpdatedData
{
    public function __construct(
        public readonly string $customerId,
        public readonly ?WebhookCardInfo $card,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            customerId: $data["customerId"],
            card: isset($data["card"]) ? WebhookCardInfo::fromArray($data["card"]) : null,
        );
    }
}
