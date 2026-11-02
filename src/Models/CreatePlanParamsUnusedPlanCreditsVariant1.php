<?php

declare(strict_types=1);

namespace Commet\Models;

class CreatePlanParamsUnusedPlanCreditsVariant1 extends CreatePlanParamsUnusedPlanCredits implements \JsonSerializable
{
    public function __construct(
        public readonly string $type,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["type"] = $this->type;
        return (object) $values;
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            type: $data["type"],
        );
    }
}
