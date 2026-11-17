<?php

declare(strict_types=1);

namespace Commet\Models;

class WebhookBalance implements \JsonSerializable
{
    public function __construct(
        public readonly bool $unlimited,
        public readonly float $purchasedBalance,
        public readonly ?float $currentBalance = null,
        public readonly ?float $planBalance = null,
        public readonly ?float $totalBalance = null,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["unlimited"] = $this->unlimited;
        if ($this->currentBalance !== null) {
            $values["currentBalance"] = $this->currentBalance;
        }
        if ($this->planBalance !== null) {
            $values["planBalance"] = $this->planBalance;
        }
        $values["purchasedBalance"] = $this->purchasedBalance;
        if ($this->totalBalance !== null) {
            $values["totalBalance"] = $this->totalBalance;
        }
        return (object) $values;
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            unlimited: $data["unlimited"],
            purchasedBalance: $data["purchased_balance"],
            currentBalance: $data["current_balance"] ?? null,
            planBalance: $data["plan_balance"] ?? null,
            totalBalance: $data["total_balance"] ?? null,
        );
    }
}
