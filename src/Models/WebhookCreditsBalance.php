<?php

declare(strict_types=1);

namespace Commet\Models;

class WebhookCreditsBalance implements \JsonSerializable
{
    public function __construct(
        public readonly bool $unlimited,
        public readonly float $purchasedCredits,
        public readonly ?float $planCredits = null,
        public readonly ?float $totalCredits = null,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["unlimited"] = $this->unlimited;
        if ($this->planCredits !== null) {
            $values["planCredits"] = $this->planCredits;
        }
        $values["purchasedCredits"] = $this->purchasedCredits;
        if ($this->totalCredits !== null) {
            $values["totalCredits"] = $this->totalCredits;
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
            purchasedCredits: $data["purchased_credits"],
            planCredits: $data["plan_credits"] ?? null,
            totalCredits: $data["total_credits"] ?? null,
        );
    }
}
