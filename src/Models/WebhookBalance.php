<?php

declare(strict_types=1);

namespace Commet\Models;

class WebhookBalance implements \JsonSerializable
{
    public function __construct(
        public readonly float $currentBalance,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["currentBalance"] = $this->currentBalance;
        return (object) $values;
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            currentBalance: $data["current_balance"],
        );
    }
}
