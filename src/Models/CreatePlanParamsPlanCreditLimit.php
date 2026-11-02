<?php

declare(strict_types=1);

namespace Commet\Models;

class CreatePlanParamsPlanCreditLimit implements \JsonSerializable
{
    public function __construct(
        public readonly int $credits,
        public readonly string $interval,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["credits"] = $this->credits;
        $values["interval"] = $this->interval;
        return (object) $values;
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            credits: $data["credits"],
            interval: $data["interval"],
        );
    }
}
