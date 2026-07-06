<?php

declare(strict_types=1);

namespace Commet\Models;

class WebhookCreditsBalance
{
    public function __construct(
        public readonly float $planCredits,
        public readonly float $purchasedCredits,
        public readonly float $totalCredits,
    ) {}

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
