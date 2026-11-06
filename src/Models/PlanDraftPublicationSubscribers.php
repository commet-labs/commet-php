<?php

declare(strict_types=1);

namespace Commet\Models;

class PlanDraftPublicationSubscribers implements \JsonSerializable
{
    public function __construct(
        public readonly int $moving,
        public readonly int $keptOnVersion,
        public readonly int $needsAChange,
        /** @var PlanDraftPublicationSubscribersLeftOutItem[] */
        public readonly array $leftOut,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["moving"] = $this->moving;
        $values["keptOnVersion"] = $this->keptOnVersion;
        $values["needsAChange"] = $this->needsAChange;
        $values["leftOut"] = $this->leftOut;
        return (object) $values;
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            moving: $data["moving"],
            keptOnVersion: $data["kept_on_version"],
            needsAChange: $data["needs_a_change"],
            leftOut: array_map(fn(array $item) => PlanDraftPublicationSubscribersLeftOutItem::fromArray($item), $data["left_out"]),
        );
    }
}
