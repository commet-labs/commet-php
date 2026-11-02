<?php

declare(strict_types=1);

namespace Commet\Models;

class CreatePlanParamsUnusedPlanCreditsVariant2 extends CreatePlanParamsUnusedPlanCredits implements \JsonSerializable
{
    public function __construct(
        public readonly string $type,
        public readonly ?int $maxPlanCredits = null,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["type"] = $this->type;
        $values["maxPlanCredits"] = $this->maxPlanCredits;
        return (object) $values;
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            type: $data["type"],
            maxPlanCredits: $data["max_plan_credits"] ?? null,
        );
    }
}
