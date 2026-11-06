<?php

declare(strict_types=1);

namespace Commet\Webhooks;

use Commet\Enums\PaymentMethod;
use Commet\Models\WebhookCardInfo;

/** Fired when a saved payment method is removed from a customer: the customer unlinked it at the payment provider (for example, revoking a Mercado Pago authorization), or removed it through the customer portal. Removing a method never changes the customer's subscriptions; a renewal that finds no usable method follows the usual failed-payment recovery. */
final class PaymentMethodDetachedData
{
    public function __construct(
        public readonly string $customerId,
        public readonly PaymentMethod|string|null $paymentMethod,
        public readonly ?WebhookCardInfo $card,
        public readonly string $reason,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            customerId: $data["customerId"],
            paymentMethod: isset($data["paymentMethod"]) ? PaymentMethod::tryFrom($data["paymentMethod"]) ?? $data["paymentMethod"] : null,
            card: isset($data["card"]) ? WebhookCardInfo::fromArray($data["card"]) : null,
            reason: $data["reason"],
        );
    }
}
