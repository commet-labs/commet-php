<?php

declare(strict_types=1);

namespace Commet\Models;

class CreditGrant implements \JsonSerializable
{
    public function __construct(
        public readonly int $credits,
        public readonly string $status,
        public readonly string $object,
        public readonly bool $livemode,
        public readonly ?string $checkoutUrl = null,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["credits"] = $this->credits;
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
            credits: $data["credits"],
            status: $data["status"],
            object: $data["object"],
            livemode: $data["livemode"],
            checkoutUrl: $data["checkout_url"] ?? null,
        );
    }
}
