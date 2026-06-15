<?php

declare(strict_types=1);

namespace Commet\Webhooks;

final class WebhookCreditsBalance
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
            planCredits: $data["planCredits"],
            purchasedCredits: $data["purchasedCredits"],
            totalCredits: $data["totalCredits"],
        );
    }
}
