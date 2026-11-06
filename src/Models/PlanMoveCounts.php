<?php

declare(strict_types=1);

namespace Commet\Models;

class PlanMoveCounts implements \JsonSerializable
{
    public function __construct(
        public readonly int $moving,
        public readonly int $moved,
        public readonly int $needsAChange,
        public readonly int $leftOut,
        public readonly int $canceled,
        public readonly int $keptOnVersion,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["moving"] = $this->moving;
        $values["moved"] = $this->moved;
        $values["needsAChange"] = $this->needsAChange;
        $values["leftOut"] = $this->leftOut;
        $values["canceled"] = $this->canceled;
        $values["keptOnVersion"] = $this->keptOnVersion;
        return (object) $values;
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            moving: $data["moving"],
            moved: $data["moved"],
            needsAChange: $data["needs_a_change"],
            leftOut: $data["left_out"],
            canceled: $data["canceled"],
            keptOnVersion: $data["kept_on_version"],
        );
    }
}
