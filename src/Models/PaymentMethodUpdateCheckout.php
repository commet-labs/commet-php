<?php

declare(strict_types=1);

namespace Commet\Models;

class PaymentMethodUpdateCheckout implements \JsonSerializable
{
    public function __construct(
        public readonly string $checkoutUrl,
        public readonly string $object,
        public readonly bool $livemode,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["checkoutUrl"] = $this->checkoutUrl;
        $values["object"] = $this->object;
        $values["livemode"] = $this->livemode;
        return (object) $values;
    }

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
