<?php

declare(strict_types=1);

namespace Commet\Models;

class BalanceTopup implements \JsonSerializable
{
    public function __construct(
        public readonly int $amount,
        public readonly string $status,
        public readonly string $object,
        public readonly bool $livemode,
        public readonly ?string $checkoutUrl = null,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["amount"] = $this->amount;
        $values["status"] = $this->status;
        if ($this->checkoutUrl !== null) {
            $values["checkoutUrl"] = $this->checkoutUrl;
        }
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
            amount: $data["amount"],
            status: $data["status"],
            object: $data["object"],
            livemode: $data["livemode"],
            checkoutUrl: $data["checkout_url"] ?? null,
        );
    }
}
