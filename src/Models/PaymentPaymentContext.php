<?php

declare(strict_types=1);

namespace Commet\Models;

class PaymentPaymentContext implements \JsonSerializable
{
    public function __construct(
        public readonly string $reason,
        public readonly ?string $paymentLinkId = null,
        public readonly ?PaymentPaymentContextRecovery $recovery = null,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["reason"] = $this->reason;
        $values["paymentLinkId"] = $this->paymentLinkId;
        $values["recovery"] = $this->recovery;
        return (object) $values;
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            reason: $data["reason"],
            paymentLinkId: $data["payment_link_id"] ?? null,
            recovery: isset($data["recovery"]) ? PaymentPaymentContextRecovery::fromArray($data["recovery"]) : null,
        );
    }
}
