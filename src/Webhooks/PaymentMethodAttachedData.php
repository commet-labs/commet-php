<?php

declare(strict_types=1);

namespace Commet\Webhooks;

/** Fired when Commet records a payment method for a subscription: after a paid checkout, when a trial starts with a card on file, or when a zero-total checkout completes. The card object carries display metadata only — full numbers never leave the payment provider. */
final class PaymentMethodAttachedData
{
    public function __construct(
        public readonly string $subscriptionId,
        public readonly string $customerId,
        public readonly ?WebhookCardInfo $card,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            subscriptionId: $data["subscriptionId"],
            customerId: $data["customerId"],
            card: isset($data["card"]) ? WebhookCardInfo::fromArray($data["card"]) : null,
        );
    }
}
