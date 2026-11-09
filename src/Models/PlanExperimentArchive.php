<?php

declare(strict_types=1);

namespace Commet\Models;

class PlanExperimentArchive implements \JsonSerializable
{
    public function __construct(
        public readonly PlanExperimentArchiveExperiment $experiment,
        public readonly string $object,
        public readonly bool $livemode,
        public readonly ?string $moveId = null,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["experiment"] = $this->experiment;
        $values["moveId"] = $this->moveId;
        $values["object"] = $this->object;
        $values["livemode"] = $this->livemode;
        return (object) $values;
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            experiment: PlanExperimentArchiveExperiment::fromArray($data["experiment"]),
            object: $data["object"],
            livemode: $data["livemode"],
            moveId: $data["move_id"] ?? null,
        );
    }
}
