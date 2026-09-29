<?php

declare(strict_types=1);

namespace Commet\Models;

class WebhookCreditsBalance implements \JsonSerializable
{
    public function __construct(
        public readonly float $planCredits,
        public readonly float $purchasedCredits,
        public readonly float $totalCredits,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["planCredits"] = $this->planCredits;
        $values["purchasedCredits"] = $this->purchasedCredits;
        $values["totalCredits"] = $this->totalCredits;
        return (object) $values;
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            planCredits: $data["plan_credits"],
            purchasedCredits: $data["purchased_credits"],
            totalCredits: $data["total_credits"],
        );
    }
}
