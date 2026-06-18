<?php

declare(strict_types=1);

namespace Commet\Models;

class PaymentMethodUpdateCheckout
{
    public function __construct(
        public readonly string $checkoutUrl,
        public readonly string $object,
        public readonly bool $livemode,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            checkoutUrl: $data["checkout_url"],
            object: $data["object"],
            livemode: $data["livemode"],
        );
    }
}
