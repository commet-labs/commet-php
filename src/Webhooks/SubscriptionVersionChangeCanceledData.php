<?php

declare(strict_types=1);

namespace Commet\Webhooks;

/** Fired when a scheduled move to another plan version will no longer take effect because the subscription no longer fit the version at its renewal, or because the merchant revoked the scheduled version change or canceled the plan move. A new move that replaces it, a move made now, a plan change or an immediate cancellation sends none. The subscription stays on its version; reason says why. */
final class SubscriptionVersionChangeCanceledData
{
    public function __construct(
        public readonly string $subscriptionId,
        public readonly string $customerId,
        public readonly string $toVersionId,
        public readonly string $reason,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            subscriptionId: $data["subscriptionId"],
            customerId: $data["customerId"],
            toVersionId: $data["toVersionId"],
            reason: $data["reason"],
        );
    }
}
