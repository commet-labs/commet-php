<?php

declare(strict_types=1);

namespace Commet\Models;

class WebhookBalance implements \JsonSerializable
{
    public function __construct(
        public readonly float $currentBalance,
        public readonly float $planBalance,
        public readonly float $purchasedBalance,
        public readonly float $totalBalance,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["currentBalance"] = $this->currentBalance;
        $values["planBalance"] = $this->planBalance;
        $values["purchasedBalance"] = $this->purchasedBalance;
        $values["totalBalance"] = $this->totalBalance;
        return (object) $values;
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            currentBalance: $data["current_balance"],
            planBalance: $data["plan_balance"],
            purchasedBalance: $data["purchased_balance"],
            totalBalance: $data["total_balance"],
        );
    }
}
